<?php
namespace app\controllers;

use Yii;
use yii\web\Cookie;
use app\controllers\FrontEndController;
use app\models\Book;
use app\models\Order;
use app\models\OrderLine;

class CartController extends FrontEndController{
	public $defaultAction = 'view';

	public function actionAdd(){
		$book_id = Yii::$app->request->get('book_id');
		$qty = (Yii::$app->request->get('qty') == null || Yii::$app->request->get('qty') < 1) ? 1 : Yii::$app->request->get('qty');

		//validasi book_id
		$book = Book::findOne($book_id);
		if($book === null){
			//set error message
			Yii::$app->session->setFlash('error', 'Failed to add the book to cart, because the book is not found in our database.');
		}else{
			//cookie reader
			$read_cookies = Yii::$app->request->cookies;
			$cart_cookie_serialize = $read_cookies->getValue('cart', serialize([])); //read searialize cookie
			$cart_cookie = unserialize($cart_cookie_serialize); //unserialize cookie

			//add new book and qty to cookie
			//search book is available in cookie, if yes update the qty
			$isAvailable = false;
			foreach($cart_cookie as $i => $cart){
				if($cart['book_id'] == $book_id){
					$cart_cookie[$i]['qty'] += $qty;
					$isAvailable = true;
					break;
				}
			}

			//if the new book is not available in cookie, insert new
			if(!$isAvailable){
				$cart_cookie[] = [
					'book_id' => $book_id,
					'qty' => $qty,
				];
			}

			//cookie writer
			$write_cookie = Yii::$app->response->cookies;
			$write_cookie->add(new Cookie([
				'name' => 'cart',
				'value' => serialize($cart_cookie),
			]));

			//set success message
			Yii::$app->session->setFlash('success', "Added '<b>{$book->title}</b>' to your cart!");
		}

		//redirect to referrer
		$referrer = Yii::$app->request->referrer;
		if($referrer == null || empty($referrer)){
			return $this->goHome();
		}else{
			return $this->redirect($referrer);
		}
	}

	public function actionView(){
		$this->layout = 'detail';

		//cookie reader
		$read_cookies = Yii::$app->request->cookies;
		$cart_cookie_serialize = $read_cookies->getValue('cart', serialize([])); //read searialize cookie
		$cart_cookie = unserialize($cart_cookie_serialize); //unserialize cookie

		$lines = [];
		foreach($cart_cookie as $line){
			$lines[] = [
				'book' => Book::findOne($line['book_id']),
				'qty' => $line['qty'],
			];
		}

		return $this->render('view', ['lines' => $lines]);
	}

	public function actionUpdate(){
		if(Yii::$app->request->post()){
			$cookies = [];
			$lines = Yii::$app->request->post('qty');
			foreach($lines as $book_id => $qty){
				$book = Book::findOne($book_id);
				if($book !== null && $qty > 0){
					$cookies[] = [
						'book_id' => $book_id,
						'qty' => $qty,
					];
				}
			}

			//cookie writer
			$cookie_writer = Yii::$app->response->cookies;
			$cookie_writer->add(new Cookie([
				'name' => 'cart',
				'value' => serialize($cookies),
			]));

			Yii::$app->session->setFlash('success', 'Cart updated successfully!');
		}
		$this->redirect('view');
	}

	public function actionRemove(){
		$book_id = Yii::$app->request->get('book_id');

		//cookie reader
		$read_cookies = Yii::$app->request->cookies;
		$cart_cookie_serialize = $read_cookies->getValue('cart', serialize([])); //read searialize cookie
		$cart_cookie = unserialize($cart_cookie_serialize); //unserialize cookie

		//cookie writer
		$writer_cookie = Yii::$app->response->cookies;

		//delete from cookie
		foreach($cart_cookie as $key => $line){
			if($line['book_id'] == $book_id){
				unset($cart_cookie[$key]);
				//set to cookie
				$writer_cookie->add(new Cookie([
					'name' => 'cart',
					'value' => serialize($cart_cookie),
				]));
				break;
			}
		}

		return $this->redirect('view');
	}

	public function actionCheckOut(){
		$this->layout = 'detail';

		//cookie reader
		$read_cookies = Yii::$app->request->cookies;
		$cart_cookie_serialize = $read_cookies->getValue('cart', serialize([])); //read searialize cookie
		$cart_cookie = unserialize($cart_cookie_serialize); //unserialize cookie

		if(Yii::$app->request->post() && !Yii::$app->customer->isGuest && Yii::$app->session->get('login_as') == 'customer'){
			$customer_id = Yii::$app->customer->identity->id;

			//set data order
			$order = new Order;
			$order->customer_id = $customer_id;
			$order->order_date = date('Y-m-d H:i:s');
			$order->notes = Yii::$app->request->post('notes');

			//set total order
			$total = 0;
			foreach($cart_cookie as $line){
				$book = Book::findOne($line['book_id']);

				if($book !== null){
					$total += ($book->price * $line['qty']);
				}
			}

			//set total
			$order->total = $total;

			if($order->save()){
				//save order line
				foreach($cart_cookie as $line){
					$book = Book::findOne($line['book_id']);

					if($book !== null){
						$orderLine = new OrderLine;
						$orderLine->order_id = $order->id;
						$orderLine->qty = $line['qty'];
						$orderLine->price = $book->price;
						$orderLine->book_id = $book->id;
						$orderLine->save();
					}
				}

				//load save data
				$order = Order::findOne($order->id);

				//sent email
				$subject = Yii::$app->params['mail']['order']['subject'];
				$body = Yii::$app->params['mail']['order']['body'];
				$subject_for_admin = Yii::$app->params['mail']['order-admin']['subject'];
				$body_for_admin = Yii::$app->params['mail']['order-admin']['body'];

				//replace data
				$body = preg_replace('/{first_name}/', $order->customer->first_name, $body);
				$body = preg_replace('/{last_name}/', $order->customer->last_name, $body);
				$body = preg_replace('/{address}/', $order->customer->address, $body);
				$body = preg_replace('/{phone}/', $order->customer->phone, $body);
				$body = preg_replace('/{order_id}/', $order->id, $body);
				$body = preg_replace('/{order_date}/', Yii::$app->formatter->asDate($order->order_date), $body);
				$body = preg_replace('/{notes}/', $order->notes, $body);
				//replace data admin
				$body_for_admin = preg_replace('/{address}/', $order->customer->address, $body_for_admin);
				$body_for_admin = preg_replace('/{phone}/', $order->customer->phone, $body_for_admin);
				$body_for_admin = preg_replace('/{order_id}/', $order->id, $body_for_admin);
				$body_for_admin = preg_replace('/{order_date}/', Yii::$app->formatter->asDate($order->order_date), $body_for_admin);
				$body_for_admin = preg_replace('/{notes}/', $order->notes, $body_for_admin);

				$orderLines = '<table width="100%" style="border-collapse: collapse" border=1>
					<thead>
						<tr>
							<th>Qty</th>
							<th>Book Title</th>
							<th>ISBN</th>
							<th>Price</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>';

				$total = 0;
				foreach($order->orderLines as $orderLine){
					$orderLines.='
					<tr>
						<td>'.$orderLine->qty.'</td>
						<td>'.$orderLine->book->title.'</td>
						<td>'.$orderLine->book->isbn.'</td>
						<td align="right">'.Yii::$app->formatter->asCurrency($orderLine->price, 'USD').'</td>
						<td align="right">'.Yii::$app->formatter->asCurrency($orderLine->price * $orderLine->qty, 'USD').'</td>
					</tr>';
					$total += ($orderLine->price * $orderLine->qty);
				}

				$orderLines.='<tr><td colspan="4" align="right">Total</td><td align="right">'.Yii::$app->formatter->asCurrency($total, 'USD').'</td></tr>';
				$orderLines.='</tbody></table>';

				$body = preg_replace('/{orderlines}/', $orderLines, $body);
				$body_for_admin = preg_replace('/{orderlines}/', $orderLines, $body_for_admin);

				//sent email
				Yii::$app->mailer->compose()
					->setTo($order->customer->email)
					->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['title']])
					->setSubject($subject)
					->setHtmlBody($body)
					->send();

				//sent email to admin
				Yii::$app->mailer->compose()
					->setTo(Yii::$app->params['adminEmail'])
					->setReplyTo([$order->customer->email => $order->customer->last_name.', '.$order->customer->first_name])
					->setSubject($subject_for_admin)
					->setHtmlBody($body_for_admin)
					->send();

				Yii::$app->session->setFlash('success', 'Check out success!');

				//reset cart
				Yii::$app->response->cookies->remove('cart');

				//redirect to customer area
				return $this->redirect(['customer/order/view', 'id' => $order->id]);
			}else{
				Yii::$app->session->setFlash('error', 'Check out failed because a problem. Please try again later or you can contact us.');
				return $this->refresh();
			}
		}else{
			$lines = [];
			foreach($cart_cookie as $line){
				$lines[] = [
					'book' => Book::findOne($line['book_id']),
					'qty' => $line['qty'],
				];
			}

			return $this->render('check-out', [
				'lines' => $lines,
			]);
		}
	}
}

?>
