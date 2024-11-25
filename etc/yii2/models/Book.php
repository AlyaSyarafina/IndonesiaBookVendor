<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $title
 * @property string $publisher
 * @property string $author
 * @property string $subject_id
 * @property integer $year
 * @property string $isbn
 * @property string $language
 * @property string $numofpages
 * @property string $price
 * @property string $description
 * @property string $image_path
 * @property boolean $featured
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Subject $subject
 * @property OrderLine[] $orderLines
 */
class Book extends \yii\db\ActiveRecord
{
    public $img;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'publisher', 'author', 'year', 'subject', 'language', 'numofpages', 'price'], 'required'],
            [['year'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'img', 'featured'], 'safe'],
            [['title', 'author'], 'string', 'max' => 128],
            [['publisher'], 'string', 'max' => 64],
            [['subject_id'], 'string', 'max' => 16],
            [['isbn'], 'string', 'max' => 17],
            [['language', 'numofpages'], 'string', 'max' => 32],
            [['img'], 'image', 'maxSize' => 5000000, 'skipOnEmpty' => true], //5MB
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'publisher' => 'Publisher',
            'author' => 'Author',
            'year' => 'Year',
            'subject_id' => 'Subject',
            'isbn' => 'Isbn',
            'language' => 'Language',
            'numofpages' => 'Num of Pages',
            'price' => 'Price',
            'description' => 'Description',
            'image_path' => 'Image',
            'img' => 'Image',
            'created_at' => 'Date Added',
            'updated_at' => 'Date Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderLines()
    {
        return $this->hasMany(OrderLine::className(), ['book_id' => 'id']);
    }

    public function getSubject(){
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    public function beforeSave($insert){
        if($this->isNewRecord){
            $this->created_at = date('Y-m-d H:i:s');
        }else{
            $this->updated_at = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

	/**
	* get best seller books for last 90 days
	* @param $limit integer
	* @return app\models\Book
	*/
	public static function getBestSeller($limit){
		$sql = "SELECT `book`.*
				FROM `order_line`
				INNER JOIN `order` ON `order`.id = `order_line`.order_id
				INNER JOIN `book` ON `book`.id = `order_line`.book_id
				WHERE DATEDIFF(NOW(), `order`.order_date) <= 90
				GROUP BY book_id
				ORDER BY COUNT(*) DESC";

		$books = self::findBySql($sql)->limit($limit)->all();

		return $books;
	}

	/**
	* get recommended books by subject,author and publisher
	* @param $book Book
	* @param $number integer This is the number of recommended books to return
	* @return app\models\Book
	*/
	public static function getRecommended($book, $number = 6){
		if($book != null && $book instanceof Book){
			/*$books = self::find()->where([
				'or',
				"subject_id='{$book->subject->id}'",
				"author LIKE '%{$book->author}%'",
				"publisher='%{$book->publisher}%'",
			])->orderBy('RAND()')->limit($number)->all();*/
      $books = self::find()
            ->orWhere(['like', 'author', $book->author])
            ->orWhere(['like', 'publisher', $book->publisher])
            ->orWhere('subject_id=:subject_id', [':subject_id' => $book->subject->id])
            ->orderBy('RAND()')->limit($number)->all();
			return $books;
		}else{
			return null;
		}
	}

	/**
	* get featured book
	* @param $limit integer
	* @return app\models\Book
	*/
	public static function getFeatured($limit = -1){
		$books = self::find()->where(['featured' => true]);
		if($limit > 0){
			$books->limit($limit);
		}
		return $books->all();
	}
}
