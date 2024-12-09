<?php
namespace App\Components;

// YII original
// use yii\base\Widget;
// use app\models\Book;
// use yii\base\InvalidParamException;

// class BookSliderWidget extends Widget{	
// 	/**
// 	* Header title of the widget
// 	*/
// 	public $title;
	
// 	/**
// 	* Model of book to show
// 	*/
// 	public $books;
	
// 	public function init(){
// 		parent::init();
// 	}
	
// 	public function run(){		
// 		return $this->render('bookslider-view', [
// 			'books' => $this->books,
// 			'title' => $this->title,
// 		]);
// 	}
// }

class BookSliderWidget
{
    /**
     * Header title of the widget
     */
    private $title;

    /**
     * Array of books to display
     */
    private $books;

    /**
     * Initialize the widget with data
     * 
     * @param string $title Header title for the widget
     * @param array $books List of books to display
     */
    public function __construct(string $title = '', array $books = [])
    {
        $this->title = $title;
        $this->books = $books;
    }

    /**
     * Render the widget view
     * 
     * @return string Rendered HTML
     */
    public function render(): string
    {
        // Load the view file and pass the widget data
        return view('Components/bookslider_view', [
            'title' => $this->title,
            'books' => $this->books,
        ]);
    }
}
?>