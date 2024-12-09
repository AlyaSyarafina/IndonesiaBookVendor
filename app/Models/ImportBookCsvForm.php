<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Book;

class ImportBookCsvForm extends Model{
	public $file;

	public function rules(){
		return [
			[['file'], 'required'],
			[['file'], 'file'],
		];
	}

	public function attributeLabels()
    {
        return [
            'file' => 'Upload File',
        ];
    }

	/**
	* return Book[] books
	*/
	public function getBooks(){
		$books = Array();

        //read file
        if($this->file){
        	//open read mode file
        	$fopen = fopen($this->file->tempName, "r");
        	$i = 0;
        	while(!feof($fopen)){
        		//read csv mode
        		$columns = fgetcsv($fopen);
                if(count($columns) >= 9){
            		$books[$i] = new Book();
            		$books[$i]->title = $columns[0];
            		$books[$i]->publisher = $columns[1];
            		$books[$i]->author = $columns[2];
            		$books[$i]->year = $columns[3];
            		$books[$i]->subject_id = $columns[4];
            		$books[$i]->isbn = $columns[5];
            		$books[$i]->language = $columns[6];
            		$books[$i]->numofpages = $columns[7];
            		$books[$i]->price = preg_replace('/$/', '', $columns[8]);
            		$books[$i]->description = $columns[9];
                }

        		$i++;
        	}
        	fclose($fopen);
        }

        //delete first row, because it is the column name
        unset($books[0]);
        return $books;
	}
}