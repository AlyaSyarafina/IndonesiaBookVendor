<?php

namespace PNDevworks\AdminPanel\Controllers;

use InvalidArgumentException;
use LogModel;
use PNDevworks\AdminPanel\Config\AdminPanel;
use PNDevworks\AdminPanel\Entities\UserEntities;
use PNDevworks\AdminPanel\Libraries\Imagelib;

use function PNDevworks\AdminPanel\Helpers\adminDebugAutoForwardException;
use function PNDevworks\AdminPanel\Helpers\imagelibRenameByIndex;

class Admin extends BaseController
{

	const ROW_PER_PAGE = 100;
	const PAGINATION_STEPS = 10;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend AdminController.
	 *
	 * @var array
	 */
	protected $helpers = ['string'];

	/**
	 * Constructor.
	 */

	/**
	 * User entities
	 *
	 * @var UserEntities
	 */
	protected $userModel;

	/**
	 * The Admin panel config
	 *
	 * @var AdminPanel
	 */
	protected $config;

	/**
	 * Logging Model
	 *
	 * @var LogModel
	 */
	protected $logModel;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();

		$this->userModel = model('PNDevworks\AdminPanel\Models\UserModel')::getCurrent();
		$this->config = config('AdminPanel');
		$this->logModel = model('PNDevworks\AdminPanel\Models\LogModel');
	}

	public function index($table = NULL, $from = "1")
	{
		$tables = $this->config->admin_tables;
		if ($table === NULL) {
			$table = array_keys($tables)[0];
		}
		$search_by = array_key_exists('search_by', $tables[$table]['index']) ? $tables[$table]['index']['search_by'] : '';
		$search_by_value = $this->request->getGet('search_by');
		$self_group_by = $this->request->getGet('self_group_by');
		$self_group_by_value = $this->request->getGet('self_group_by_value');
		$db = \Config\Database::connect();

		if (in_array($table, array_keys($tables))) {
			$cols = $tables[$table]['index']['cols'];
			$group_by_exists = array_key_exists('group_by', $tables[$table]['index']);
			$self_group_by_exists = array_key_exists('self_group_by', $tables[$table]['index']) && empty($self_group_by);
			$search_by_exists = array_key_exists('search_by', $tables[$table]['index']) && !empty($search_by_value);

			if ($search_by_exists) {
				if (array_key_exists('links', $tables[$table]['index'])) {
					$joins = $tables[$table]['index']['links'];
					$select = $table . '.*';
					foreach ($joins as $key => $val) {
						$select .= ', ' . $joins[$key]['table'] . '.' . $joins[$key]['label'] . ' AS ' . $joins[$key]['table'] . '_' . $joins[$key]['label'];
					}
					$builder = $db->table($table);
					$builder->select($select);
					foreach ($joins as $key => $val) {
						$builder->join($joins[$key]['table'], $table . '.' . $key . ' = ' . $joins[$key]['table'] . '.id', 'left');
					}
				} else {
					$builder = $db->table($table);
				}
				if (!empty($self_group_by) && !empty($self_group_by_value)) {
					$builder->where($self_group_by, $self_group_by_value);
				}
				if (!empty($search_by)) {
					$builder->like($search_by[0], $search_by_value, 'both');
					if (count($search_by) > 1) {
						$search_by_temp = array_slice($search_by, 1);
						foreach ($search_by_temp as $search) {
							if ($search === 'id' || $search === $table . '.id') {
								$builder->orLike($table . '.id', $search_by_value, 'both');
							} else {
								if (array_key_exists('links', $tables[$table]['index'])) {
									if (array_key_exists($search, $tables[$table]['index']['links'])) {
										$builder->orLike($tables[$table]['index']['links'][$search]['table'] . '.' . $tables[$table]['index']['links'][$search]['label'], $search_by_value, 'both');
									}
								} else {
									$builder->orLike($search, $search_by_value, 'both');
								}
							}
						}
					}
				}
				$total_row = $builder->countAllResults(false);
				$total_page = ceil($total_row / self::ROW_PER_PAGE);
				$order_by = $tables[$table]['index']['order_by'];
				$builder->orderBy($order_by[0], $order_by[1]);
				$builder->limit(self::ROW_PER_PAGE, ($from - 1) * self::ROW_PER_PAGE);
				$query = $builder->get();
				$rows = $query->getResultArray();
			} elseif ($self_group_by_exists) {
				$self_group_by_data = $tables[$table]['index']['self_group_by'];
				if ($this->request->getGet('self_group_by_col') !== null) {
					$self_group_by_data['col'] = $this->request->getGet('self_group_by_col');
				}

				$builder = $db->table($table);
				$builder->select($self_group_by_data['col'] . ', COUNT(' . $self_group_by_data['counter'] . ') as count_' . $self_group_by_data['counter'] . '');
				$builder->groupBy($self_group_by_data['col']);
				$total_row = $builder->countAllResults(false);
				$total_page = ceil($total_row / self::ROW_PER_PAGE);
				$builder->orderBy($self_group_by_data['col'], "asc");
				$builder->limit(self::ROW_PER_PAGE, ($from - 1) * self::ROW_PER_PAGE);
				$query = $builder->get();
				$rows = $query->getResult();
				if (array_key_exists('links', $tables[$table]['index'])) {
					if (array_key_exists($self_group_by_data['col'], $tables[$table]['index']['links'])) {
						$links = $tables[$table]['index']['links'][$self_group_by_data['col']];
						foreach ($rows as $row) {
							$builder = $db->table($links['table']);
							$builder->select($links['label']);
							$row->{$self_group_by_data['col']} .= " / " . $builder->getWhere([
								'id' => $row->{$self_group_by_data['col']}
							])->getRow()->{$links['label']};
						}
					}
				}
			} elseif ($group_by_exists) {
				if (empty($this->request->getGet('group_by'))) {
					$table_group_by = $tables[$table]['index']['group_by'][0]['table'];
				} else {
					$table_group_by = $this->request->getGet('group_by');
				}
				foreach ($tables[$table]['index']['group_by'] as $j => $group_by) {
					if ($group_by['table'] === $table_group_by) {
						$k = $j;
						if (isset($tables[$table]['index']['group_by'][$k + 1]['table'])) {
							$group_by_next = $tables[$table]['index']['group_by'][$k + 1]['table'];
						}
						$select = $group_by['table'] . '.id, ' . $group_by['table'] . '.' . $group_by['label'] . ' AS "' . $group_by['table'] . '.' . $group_by['label'] . '", count(' . $group_by['table'] . '.id) AS total';
						$builder = $db->table($table);
						$builder->select($select);
						$i = 0;
						if (array_key_exists('joins', $group_by)) {
							foreach ($group_by['joins'] as $key => $val) {
								$join_table[$i] = explode('.', $val)[0];
								if ($i === 0) {
									$on[$i] = $table . '.' . $key . '=' . $val;
									if ($key === 'last') {
										$on[$i] = $group_by['table'] . '.id=' . $table . '.' . $val;
									}
								} else {
									$on[$i] = $join_table[$i - 1] . '.' . $key . '=' . $val;
									if ($key === 'last') {
										$on[$i] = $group_by['table'] . '.id=' . $join_table[$i - 1] . '.' . $val;
									}
								}
								if ($key !== 'last') {
									$builder->join($join_table[$i], $on[$i]);
								} else {
									$builder->join($group_by['table'], $on[$i]);
									$last = $join_table[$i];
								}
								if ($k > 0) {
									$previous_table_last = $tables[$table]['index']['group_by'][$k - 1]['joins']['last'];
									if (isset($previous_table_last)) {
										$builder->where($group_by['table'] . '.' . $previous_table_last, $this->request->getGet($previous_table_last));
									}
								}
								$i++;
							}
							$builder->groupBy($group_by['table'] . '.id');
						}
						$total_row = $builder->countAllResults(false);
						$total_page = ceil($total_row / self::ROW_PER_PAGE);
						$builder->orderBy('total', 'desc');
						$builder->limit(self::ROW_PER_PAGE, ($from - 1) * self::ROW_PER_PAGE);
						$rows = $builder->get()->getResult();
						$label = $group_by['table'] . '.' . $group_by['label'];
						$total_record = 0;
						foreach ($rows as $key => $row) {
							$data_table_grafik[$label][$key] = $row->$label;
							$data_table_grafik['total'][$key] = $row->total * 1;
							$total_record += $row->total * 1;
						}
					}
				}
				if ($table_group_by === $table) {
					if (array_key_exists('links', $tables[$table]['index'])) {
						$joins = $tables[$table]['index']['links'];
						$select = $table . '.*';
						foreach ($joins as $key => $val) {
							$select .= ', ' . $joins[$key]['table'] . '.' . $joins[$key]['label'] . ' AS ' . $joins[$key]['table'] . '_' . $joins[$key]['label'];
						}
						$builder = $db->table($table);
						$builder->select($select);
						foreach ($joins as $key => $val) {
							$builder->join($joins[$key]['table'], $table . '.' . $key . ' = ' . $joins[$key]['table'] . '.id', 'left');
						}
					} else {
						$builder = $db->table($table);
					}
					$size_of_group_by = sizeof($tables[$table]['index']['group_by']);
					$i = 0;
					foreach ($tables[$table]['index']['group_by'][$size_of_group_by - 1]['joins'] as $key => $join) {
						$join_table[$i] = explode('.', $join)[0];
						if ($key === 'last') {
							$last = $join;
							if ($i > 0) {
								$where = $join_table[$i - 1] . '.' . $join;
							} else if ($i == 0) {
								$where = $table . '.' . $join;
							}
						}
						$i++;
					}
					if (isset($where) && isset($last)) {
						$builder->where($where, $this->request->getGet($last));
					}
					$total_row = $builder->countAllResults(false);
					$total_page = ceil($total_row / self::ROW_PER_PAGE);
					$order_by = $tables[$table]['index']['order_by'];
					$builder->orderBy($order_by[0], $order_by[1]);
					$builder->limit(self::ROW_PER_PAGE, ($from - 1) * self::ROW_PER_PAGE);
					$query = $builder->get();
					$rows = $query->getResultArray();
				}
			} elseif ($this->request->getGet('search_item') != null && $this->request->getGet('search_item') != '') {

				if (array_key_exists('links', $tables[$table]['index'])) {
					$joins = $tables[$table]['index']['links'];
					$select = $table . '.*';
					foreach ($joins as $key => $val) {
						$select .= ', ' . $joins[$key]['table'] . '.' . $joins[$key]['label'] . ' AS ' . $joins[$key]['table'] . '_' . $joins[$key]['label'];
					}
					$builder = $db->table($table);
					$builder->select($select);
					foreach ($joins as $key => $val) {
						$builder->join($joins[$key]['table'], $table . '.' . $key . ' = ' . $joins[$key]['table'] . '.id', 'left');
					}
				} else {
					$builder = $db->table($table);
				}
				if (!empty($self_group_by) && !empty($self_group_by_value)) {
					$builder->where($self_group_by, $self_group_by_value);
				}
				$index = 0;
				$searchable_cols = (array_key_exists('searchable_column', $tables[$table]['index']['search'])) ? $tables[$table]['index']['search']['searchable_column'] : $tables[$table]['index']['cols'];
				foreach ($searchable_cols as $haystack) {
					if ($index == 0) {
						$builder->like($haystack, $this->request->getGet('search_item'));
					} else {
						$builder->orLike($haystack, $this->request->getGet('search_item'));
					}
					$index += 1;
				}
				$total_row = $builder->countAllResults(false);
				$total_page = ceil($total_row / self::ROW_PER_PAGE);
				$order_by = $tables[$table]['index']['order_by'];
				for ($i = 0; $i < sizeof($order_by); $i += 2) {
					$builder->orderBy($order_by[$i], $order_by[$i + 1]);
				}
				$builder->limit(self::ROW_PER_PAGE, ($from - 1) * self::ROW_PER_PAGE);
				$query = $builder->get();
				$rows = $query->getResultArray();
			} else {
				if (array_key_exists('links', $tables[$table]['index'])) {
					$joins = $tables[$table]['index']['links'];
					$select = $table . '.*';
					foreach ($joins as $key => $val) {
						$select .= ', ' . $joins[$key]['table'] . '.' . $joins[$key]['label'] . ' AS ' . $joins[$key]['table'] . '_' . $joins[$key]['label'];
					}
					$builder = $db->table($table);
					$builder->select($select);
					foreach ($joins as $key => $val) {
						$builder->join($joins[$key]['table'], $table . '.' . $key . ' = ' . $joins[$key]['table'] . '.id', 'left');
					}
				} else {
					$builder = $db->table($table);
				}
				if (!empty($self_group_by) && !empty($self_group_by_value)) {
					$builder->where($self_group_by, $self_group_by_value);
				}
				$total_row = $builder->countAllResults(false);
				$total_page = ceil($total_row / self::ROW_PER_PAGE);
				$order_by = $tables[$table]['index']['order_by'];
				for ($i = 0; $i < sizeof($order_by); $i += 2) {
					$builder->orderBy($order_by[$i], $order_by[$i + 1]);
				}
				$builder->limit(self::ROW_PER_PAGE, ($from - 1) * self::ROW_PER_PAGE);
				$query = $builder->get();
				$rows = $query->getResultArray();
			}
			$allow = $tables[$table]['allow'];
			return view('PNDevworks\AdminPanel\Views\Admin\index_', [
				'table' => $table,
				'extra' => $tables[$table],
				'cols' => $cols,
				'rows' => isset($rows) ? $rows : [],
				'allow' => $allow,
				'links' => array_key_exists('links', $tables[$table]['index']) ? $tables[$table]['index']['links'] : [],
				'total_page' => $total_page,
				'from' => $from,
				'pagination_steps' => self::PAGINATION_STEPS,
				'group_by_next' => isset($group_by_next) ? $group_by_next : $table,
				'id_table' => isset($last) ? $last : '',
				'total_records' => $total_row,
				'totals' => isset($total_record) ? $total_record : 0,
				'group_by_exists' => $group_by_exists,
				'self_group_by_exists' => $self_group_by_exists,
				'self_group_by_data' => isset($self_group_by_data) ? $self_group_by_data : null,
				'search_by' => (isset($search_by) && !empty($search_by)) ? $search_by : null,
				'table_group_by' => isset($table_group_by) ? $table_group_by : $table,
				'current_no_group_by' => isset($k) ? $k : 1,
				'previous_id_table' => isset($previous_table_last) ? $previous_table_last : '',
				'label' => isset($label) ? $label : '',
				'self_group_by_col' => $this->request->getGet('self_group_by_col'),

			]);
		} else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function update($table = NULL, $id = NULL)
	{
		$tables = $this->config->admin_tables;

		try {
			if ($table === NULL || $id === NULL) {
				throw new \UnexpectedValueException("Incomplete parameter on update: $table/$id");
			}

			$db = \Config\Database::connect();
			$builder = $db->table($table);

			if (in_array($table, array_keys($tables))) {
				if (!in_array('update', $tables[$table]['allow'])) {
					throw new \UnexpectedValueException("Update operation not allowed on $table");
				}
				if (strtolower($this->request->getMethod()) === 'post') {
					$this->logModel->notice("Update $table/$id by " . $this->userModel->id, $this->request->getPost());
					$cols = $tables[$table]['update'];
					$table_data = [];
					if ($cols === 'configurations') {
						$table_data['value'] = $this->request->getPost(str_replace('.', '_', $id));
					} else {
						foreach ($cols as $key => $col) {
							if ($key === 'admin_extras') {
								continue;
							}
							if ($col['type'] === 'password') {
								$value = $this->request->getPost($key);
								if ($value !== NULL && $value !== '') {
									if (key_exists('scope', $col) && $col['scope'] === 'self' && $id !== $this->userModel->id) {
										throw new \UnexpectedValueException("Not allowed to update password for different user");
									}

									$authConfig = config('Authentication');
									$table_data[$key] = password_hash($value, $authConfig->passwordAlgorithm, $authConfig->passwordAlgorithmParams);
									$this->flashMessages->addMessage('info', "Password updated");
								} else {
									$this->flashMessages->addMessage('info', "Password not updated");
								}
								continue;
							} elseif ($col['type'] === 'json') {
								$table_data[$key] = json_encode(json_decode($this->request->getPost($key)));
							} else {
								if (array_key_exists('allow_null', $col) && $col['allow_null'] === TRUE && empty($this->request->getPost($key))) {
									$table_data[$key] = NULL;
								} else {
									$table_data[$key] = $this->request->getPost($key);
								}
							}
						}
					}
					$builder->where(['id' => $id]);
					if (!$builder->update($table_data)) {
						throw new \Exception($db->error()['message']);
					}
					$this->flashMessages->addMessage('success', "Successfully updated " . $tables[$table]['label']);
					return redirect()->to(site_url(route_to('pnd_admin_update', $table, $id)));
				} else {
					$fields = $db->getFieldNames($table);
					$query = $builder->getWhere(['id' => $id]);
					$row = $query->getRowArray();
					$allow = $tables[$table]['allow'];
					$options = $tables[$table]['update'];
					if ($options === 'configurations') {
						return view('PNDevworks\AdminPanel\Views\Admin\update_configurations', [
							'table' => $table,
							'row' => $row
						]);
					} else {
						return view('PNDevworks\AdminPanel\Views\Admin\update', [
							'table' => $table,
							'fields' => $fields,
							'allow' => $allow,
							'row' => $row,
							'options' => $options,
							'userModel' => $this->userModel,
						]);
					}
				}
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		} catch (\Exception $e) {
			$this->logModel->exception($e);

			helper('adminDebug_helper');
			adminDebugAutoForwardException($e);

			$this->flashMessages->addMessage('danger', $e->getMessage());
			return redirect()->to(site_url(route_to('pnd_admin_index', $table, 1)));
		}
	}

	public function create($table = NULL)
	{
		$tables = $this->config->admin_tables;

		try {
			if ($table === NULL) {
				throw new \UnexpectedValueException("Incomplete parameter on create: $table");
			}

			$db = \Config\Database::connect();
			$builder = $db->table($table);

			if (in_array($table, array_keys($tables))) {
				if (!in_array('create', $tables[$table]['allow'])) {
					throw new \UnexpectedValueException("Create operation not allowed on $table");
				}
				if (strtolower($this->request->getMethod()) === 'post') {
					$this->logModel->notice("Created $table by " . $this->userModel->id, $this->request->getPost());
					$cols = $tables[$table]['create'];
					$table_data = [];
					foreach ($cols as $key => $col) {
						if ($key === 'admin_extras') {
							continue;
						}
						if (array_key_exists('allow_null', $col) && $col['allow_null'] === TRUE && empty($this->request->getPost($key))) {
							$table_data[$key] = NULL;
						} else {
							$table_data[$key] = $this->request->getPost($key);
						}
						if ($col['type'] === 'password') {
							$authConfig = config('Authentication');
							$table_data[$key] = password_hash($table_data[$key], $authConfig->passwordAlgorithm, $authConfig->passwordAlgorithmParams);
						}
					}
					$builder->insert($table_data);
					if ($db->affectedRows() < 0) {
						throw new \Exception($db->error()['message']);
					}
					$id = $db->insertID();
					$this->flashMessages->addMessage('success', "Successfully created " . $tables[$table]['label']);
					return redirect()->to(site_url(route_to('pnd_admin_update', $table, $id)));
				} else {
					$fields = $db->getFieldNames($table);
					$allow = $tables[$table]['allow'];
					$options = $tables[$table]['create'];
					return view('PNDevworks\AdminPanel\Views\Admin\create', [
						'table' => $table,
						'fields' => $fields,
						'allow' => $allow,
						'options' => $options,

					]);
				}
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		} catch (\Exception $e) {
			$this->logModel->exception($e);

			helper('adminDebug_helper');
			adminDebugAutoForwardException($e);

			$this->flashMessages->addMessage('danger', $e->getMessage());
			return redirect()->to(site_url(route_to('pnd_admin_index', $table, 1)));
		}
	}

	public function delete($table = NULL, $id = NULL)
	{
		$tables = $this->config->admin_tables;

		try {
			if ($table === NULL || $id === NULL) {
				throw new \UnexpectedValueException("Incomplete parameter on delete: $table/$id");
			}

			$db = \Config\Database::connect();
			$builder = $db->table($table);

			if (in_array($table, array_keys($tables))) {
				if (!in_array('delete', $tables[$table]['allow'])) {
					throw new \UnexpectedValueException("Delete operation not allowed on $table");
				}
				if ($this->request->getPost('confirm') === 'yes') {
					$this->logModel->notice("Delete $table/$id by " . $this->userModel->id, $this->request->getPost());
					$row = 	$builder->getWhere(['id' => $id])->getRow();
					if (!$builder->delete(['id' => $id])) {
						throw new \Exception($db->error()['message']);
					}
					$this->flashMessages->addMessage('success', "Successfully deleted " . $tables[$table]['label']);
					return redirect()->to(site_url(route_to('pnd_admin_index', $table, 1)));
				} else {
					$fields = $db->getFieldNames($table);
					$query = $builder->getWhere(['id' => $id]);
					$row = $query->getRowArray();
					return view('PNDevworks\AdminPanel\Views\Admin\delete', [
						'table' => $table,
						'fields' => $fields,
						'row' => $row,

					]);
				}
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		} catch (\Exception $e) {
			helper('adminDebug_helper');
			adminDebugAutoForwardException($e);

			// this error code is used to check "Cannot delete or update a parent row"
			// this will make sure the client understand the error to delete the record that linked to parent table first
			if($e->getCode() == 1451){
				foreach($tables as $key => $current_table){
					if(array_key_exists('links', $current_table['index'])){
						foreach($current_table['index']['links'] as $link_key => $link){
							if($link['table'] == $table){
								$builder = $db->table($key);
								$linked_result = $builder->getWhere([$link_key => $id])->getRow();
								$message = "You must delete the data with id=" . $linked_result->id . " on " . $current_table['label'] . " first.";
								$this->flashMessages->addMessage('danger', $message);
							}
						}
					}
				}
			}
			else{
				$this->flashMessages->addMessage('danger', $e->getMessage());
			}

			return redirect()->to(site_url(route_to('pnd_admin_index', $table, 1)));
		}
	}

	public function upload($table = NULL, $id = NULL)
	{
		$tables = $this->config->admin_tables;

		try {
			if ($table === NULL || $id === NULL) {
				throw new \UnexpectedValueException("Incomplete parameter on upload: $table/$id");
			}

			if (!in_array($table, array_keys($tables)) || strtolower($this->request->getMethod()) !== 'post') {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}

			if (!in_array('update', $tables[$table]['allow'])) {
				throw new \UnexpectedValueException("Upload/update operation not allowed on $table");
			}


			$this->logModel->notice("Upload $table/$id by " . $this->userModel->id);

			if ($this->request->getPost('type') === 'files') {
				$config2 = $tables[$table]['update']['admin_extras']['files'];
				$config2['upload_path'] = 'assets/uploads';

				$file = $this->request->getFile('userfile2');
				if (!$file->isValid()) {
					throw new \UnexpectedValueException($file->getErrorString());
				}

				if ($file->getExtension() != $config2['target_extension']) {
					throw new \UnexpectedValueException('The filetype you are attempting to upload is not allowed');
				}

				$filename_prefix = $config2['upload_path'] . '/' . $table . '-' . $this->request->getPost('type') . '-' . $id . '-';
				$counter = 0;
				while (file_exists($filename_prefix . $counter . '.' . $config2['target_extension'])) {
					$counter++;
				}

				$filename = $table . '-' . $this->request->getPost('type') . '-' . $id . '-' . $counter . '.' . $config2['target_extension'];
				$file->move($config2['upload_path'], $filename, true);
			} else if ($this->request->getPost('type') === 'videos') {
				$config2 = $tables[$table]['update']['admin_extras']['videos'];
				$config2['upload_path'] = 'assets/uploads';

				$file = $this->request->getFile('userfile2');
				if (!$file->isValid()) {
					throw new \UnexpectedValueException($file->getErrorString());
				}

				if ($file->getExtension() != $config2['target_extension']) {
					throw new \UnexpectedValueException('The filetype you are attempting to upload is not allowed');
				}

				$filename_prefix = $config2['upload_path'] . '/' . $table . '-' . $this->request->getPost('type') . '-' . $id . '-';
				$counter = 0;
				while (file_exists($filename_prefix . $counter . '.' . $config2['target_extension'])) {
					$counter++;
				}

				$filename = $table . '-' . $this->request->getPost('type') . '-' . $id . '-' . $counter . '.' . $config2['target_extension'];
				$file->move($config2['upload_path'], $filename, true);
			} else {

				$config = $tables[$table]['update']['admin_extras']['images'];
				$config['upload_path'] = 'assets/uploads';

				if($this->config->fileUploadAllowMultipleMimeTypes) {
					$rules = [
						'uploaded[userfile]',
						'is_image[userfile]'
					];
					if (array_key_exists('allowed_mimetypes', $config)) {
						$rules[] = 'mime_in[userfile,' . $config['allowed_mimetypes'] . ']';
					}
					if (array_key_exists('max_size', $config)) {
						$rules[] = 'max_size[userfile,' . $config['max_size'] . ']';
					}
					if (array_key_exists('max_width', $config) && array_key_exists('max_height', $config)) {
						$rules[] = 'max_dims[userfile,' . $config['max_width'] . ',' . $config['max_height'] . ']';
					}
					$validationRule = [
						'userfile' => [
							'label' => 'Image File',
							'rules' => $rules,
						],
					];
					if (! $this->validate($validationRule)) {
						throw new \Exception(implode(', ', $this->validator->getErrors()));
					}
				}

				$file = $this->request->getFile('userfile');
				if (!$file->isValid()) {
					throw new \UnexpectedValueException($file->getErrorString());
				}

				if (!$this->config->fileUploadAllowMultipleMimeTypes && $file->getExtension() != $config['target_extension']) {
					throw new \UnexpectedValueException('The filetype you are attempting to upload is not allowed');
				}

				$filename_prefix = $config['upload_path'] . '/' . $table . '-' . $this->request->getPost('type') . '-' . $id . '-';
				$counter = 0;
				while (file_exists($filename_prefix . $counter . '.' . $config['target_extension'])) {
					$counter++;
				}
				$filename = $table . '-' . $this->request->getPost('type') . '-' . $id . '-' . $counter . '.' . $config['target_extension'];
				$file->move($config['upload_path'], $filename, true);

				$autoconvert = ($config['autoconvert'] ?? ['enable' => false]);
				if ($autoconvert['enable']) {
					Imagelib::transformImages($config['upload_path'] . "/" . $filename, $table, $id, $counter, $autoconvert);
				}
			}

			$this->flashMessages->addMessage('success', "Successful upload for " . $tables[$table]['label']);

			return redirect()->to(site_url(route_to('pnd_admin_update',  $table, $id)));
		} catch (\Exception $e) {
			helper('adminDebug_helper');
			adminDebugAutoForwardException($e);

			$this->flashMessages->addMessage('danger', $e->getMessage());
			return redirect()->to(site_url(route_to('pnd_admin_index', $table, 1)));
		}
	}

	public function uploadmanipulate($table = NULL, $id = NULL)
	{
		$tables = $this->config->admin_tables;

		try {
			if ($table === NULL || $id === NULL) {
				throw new \UnexpectedValueException("Incomplete parameter on uploadmanipulate: $table/$id");
			}

			$this->logModel->notice("Uploadmanipulate $table/$id by " . $this->userModel->id, $this->request->getPost());

			if (!in_array($table, array_keys($tables))) {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}

			if (!in_array('update', $tables[$table]['allow'])) {
				throw new \UnexpectedValueException("Upload Manipulate/update operation not allowed on $table");
			}

			$config = $tables[$table]['update']['admin_extras']['images'] ?? [];

			if ($this->request->getPost('type') === 'files') {
				$config = $tables[$table]['update']['admin_extras']['files'];
			}

			$filename_prefix = 'assets/uploads/' . $table . '-' . $this->request->getPost('type') . '-' . $id . '-';

			$autoconvert = ($config['autoconvert'] ?? ['enable' => false]);
			$images = [];
			if ($autoconvert['enable']) {
				try {
					$images = Imagelib::getImages($table, $id, true);
				} catch (InvalidArgumentException $e) {
					// To silence the error
				}
			}

			switch ($this->request->getPost('action')) {
				case 'swapwithnext':
					$index = intval($this->request->getPost('index'));
					$filename1 = $filename_prefix . $index . '.' . $config['target_extension'];
					$filename2 = $filename_prefix . ($index + 1) . '.' . $config['target_extension'];
					$tempfile = $filename_prefix . rand() . '.' . $config['target_extension'];
					rename($filename1, $tempfile);
					rename($filename2, $filename1);
					rename($tempfile, $filename2);

					if ($autoconvert['enable']) {
						helper('imagelibExtras_helper');

						$rand = rand($index + 1, PHP_INT_MAX);
						$group1 = $images[$index];
						$group2 = $images[$index + 1];
						imagelibRenameByIndex($group1, $rand);
						imagelibRenameByIndex($group2, $index);
						imagelibRenameByIndex($group1, $index + 1);
					}

					$this->flashMessages->addMessage('success', "Successful swap file for " . $tables[$table]['label']);
					return redirect()->to(site_url(route_to('pnd_admin_update',  $table, $id)));
					break;

				case 'delete':
					$index = intval($this->request->getPost('index'));
					$filename = $filename_prefix . $index . '.' . $config['target_extension'];
					if (!unlink($filename)) {
						throw new \UnexpectedValueException("Failed to delete file (probably due to file permission)");
					}
					if ($autoconvert['enable']) {
						foreach ($images[$index] as $img) {
							if (!unlink($img['fullname'])) {
								throw new \UnexpectedValueException("Failed to delete file (probably due to file permission)");
							}
						}
					}

					for ($i = $index; file_exists($filename_prefix . ($i + 1) . '.' . $config['target_extension']); $i++) {
						rename(
							$filename_prefix . ($i + 1) . '.' . $config['target_extension'],
							$filename_prefix . $i . '.' . $config['target_extension']
						);

						if ($autoconvert['enable']) {
							helper('imagelibExtras_helper');

							imagelibRenameByIndex($images[$i + 1], $i);
						}
					}

					$this->flashMessages->addMessage('success', "Successful delete file for " . $tables[$table]['label']);
					return redirect()->to(site_url(route_to('pnd_admin_update',  $table, $id)));
					break;
				default:
					throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
			return redirect()->to(site_url(route_to('pnd_admin_update',  $table, $id)));
		} catch (\Exception $e) {
			helper('adminDebug_helper');
			adminDebugAutoForwardException($e);

			$this->flashMessages->addMessage('danger', $e->getMessage());
			return redirect()->to(site_url(route_to('pnd_admin_index', $table, 1)));
		}
	}

	public function csv($table = NULL)
	{
		$tables = $this->config->item('admin_tables');
		$db = \Config\Database::connect();
		try {
			if ($table === NULL) {
				throw new \UnexpectedValueException("Incomplete parameter (table) on CSV export");
			}
			if (in_array($table, array_keys($tables))) {
				// Construct fields if extract json is found
				$cols = $db->getFieldNames($table);
				$cleaned_cols = NULL;
				$json_field_indexes = [];
				$skipped_col_indexes = [];
				if (array_key_exists('csv_extract_json', $tables[$table]['index'])) {
					$extract_json = $tables[$table]['index']['csv_extract_json'];
					$builder = $db->table($table);
					$query = $builder->get();
					while ($row = $query->unbuffered_row('array')) {
						foreach ($extract_json as $field) {
							$array = json_decode($row[$field], TRUE);
							if (is_array($array)) {
								foreach ($array as $key => $value) {
									if (!array_key_exists($key, $json_field_indexes)) {
										$json_field_indexes[$key] = sizeof($cols);
										$cols[] = $field . '_' . $key;
									}
								}
							}
						}
					}
					$cleaned_cols = [];
					foreach ($cols as $i => $col) {
						if (!in_array($col, $extract_json)) {
							$cleaned_cols[] = $col;
						} else {
							$skipped_col_indexes[] = $i;
						}
					}
				} else {
					$cleaned_cols = $cols;
				}
				$order_by = $tables[$table]['index']['order_by'];
				$builder = $db->table($table);
				$builder->orderBy($order_by[0], $order_by[1]);
				$query = $db->get();
				header('Content-type: text/csv');
				header('Content-disposition: attachment; filename="' . $table . '.csv"');
				$f = fopen('php://output', 'w');
				fputcsv($f, $cleaned_cols);
				while ($row = $query->unbuffered_row('array')) {
					$row_values = [];
					$cleaned_row_values = NULL;
					foreach ($row as $key => $value) {
						$row_values[] = $value;
					}
					if (array_key_exists('csv_extract_json', $tables[$table]['index'])) {
						while (sizeof($row_values) < sizeof($cols)) {
							$row_values[] = '';
						}
						$extract_json = $tables[$table]['index']['csv_extract_json'];
						foreach ($extract_json as $field) {
							$array = json_decode($row[$field], TRUE);
							if (is_array($array)) {
								foreach ($array as $key => $value) {
									$row_values[$json_field_indexes[$key]] = is_array($value) ? json_encode($value) : $value;
								}
							}
						}
						foreach ($row_values as $i => $row) {
							if (!in_array($i, $skipped_col_indexes)) {
								$cleaned_row_values[] = $row;
							}
						}
					} else {
						$cleaned_row_values = $row_values;
					}
					fputcsv($f, $cleaned_row_values);
				}
				fclose($f);
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		} catch (\Exception $e) {
			helper('adminDebug_helper');
			adminDebugAutoForwardException($e);

			$this->flashMessages->addMessage('danger', $e->getMessage());
			header('Location: ' . site_url(route_to('pnd_admin_index', $table, 1)));
		}
	}
}
