<?php

namespace app\controllers\backend;

use Yii;
use app\models\Book;
use app\models\BookSearch;
use app\models\ImportBookCsvForm;
use app\controllers\backend\BackendController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\imagine\Image;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends BackendController
{
    public function behaviors()
    {
        return \yii\helpers\BaseArrayHelper::merge([
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-all' => ['post'],
                ],
            ],
        ], parent::behaviors());
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->img = UploadedFile::getInstance($model, 'img');

            if($model->img != null){
                //upload image to path web/uploads
                $path_to_upload = 'uploads/'.time().'-'.$model->img->baseName.".".$model->img->extension;
                $model->image_path = $path_to_upload;
            }else{
                $model->image_path = null;
            }

            if($model->save()){
                if($model->img != null){
                    $model->img->saveAs($path_to_upload);

                    //resize image to 200x300 px
                    Image::thumbnail("@webroot/$path_to_upload", 200, 300)->save("$path_to_upload");
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->img = UploadedFile::getInstance($model, 'img');
            //save old image path to variable, needed for delete
            $old_image = $model->image_path;

            if($model->img != null){
                //upload new image to path web/uploads
                $path_to_upload = 'uploads/'.time().'-'.$model->img->baseName.".".$model->img->extension;
                $model->image_path = $path_to_upload;
            }else{
                //unset image_path so the data will not be saved
                unset($model->image_path);
            }
            if($model->save()){
                if($model->img != null){
                    $model->img->saveAs($path_to_upload);

                    //resize image to 200x300 px
                    Image::thumbnail("@webroot/$path_to_upload", 200, 300)->save("$path_to_upload");

                    //delete old image
                    @unlink($old_image);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $book = $this->findModel($id);

        //delete image
        if($book->image_path != null) @unlink($book->image_path);

        $book->delete();

        if(Yii::$app->request->getReferrer() == ''){
          return $this->redirect(['index']);
        }else{
          return $this->redirect(Yii::$app->request->getReferrer());
        }
    }

    public function actionDeleteAll()
    {
        $ids = Yii::$app->request->post("ids");
        if(is_array($ids)){
          foreach($ids as $id){
            $book = $this->findModel($id);

            //delete image
            if($book->image_path != null) @unlink($book->image_path);

            $book->delete($id);
          }

          if(Yii::$app->request->getReferrer() == ''){
            return $this->redirect(['index']);
          }else{
            return $this->redirect(Yii::$app->request->getReferrer());
          }
        }
    }

    public function actionImport(){
        $model = new ImportBookCsvForm();

        if($model->load(Yii::$app->request->post())){
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file && $model->validate()){
                $books = $model->getBooks();
                //save book in session in json format
                Yii::$app->session->set("books", serialize($books));


                return $this->render('import_selection', ['model' => $books]);
            }
        }else{
            return $this->render('import', ['model' => $model]);
        }
    }

    public function actionSaveImport(){
        $books = Yii::$app->request->post("books");
        $books_on_session = unserialize(Yii::$app->session->get("books"));

        $results = Array();
        foreach($books as $key => $book){
            $model = $books_on_session[$key];
            if($model){
                if($model->save()){
                    $results[$key]['success'] = "Book {$model->title} imported successfully.";
                }else{
                    $results[$key]['error'] = "Failed to import book {$model->title}.";
                }
            }
        }

        //unset session
        Yii::$app->session->remove("books");

        return $this->render('save_import', ['results' => $results]);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
