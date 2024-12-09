<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* var $model app\models\ImportBookCsvForm */
/* var $this yii\web\View */

$this->title = "Import Book";
$this->params['breadcrumbs'][] = ['label' => 'Book', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Import'];
?>
<h3>Please pay attention to the guide before importing data.</h3>
<p>This tool allows you to import book data from Microsoft Excel. As the format of Excel and web differs, there are some paperworks to do.</p>

<p>First thing first, you must adjust the book data you have with .txt format. Download the <?= Html::a('sample_v2.csv', '@web/assets/download/sample_v2.csv') ?> file for an example.</p>

<p>In order to be retreived correctly, your Excel data must obey this rule: put book in rows, where first column being the title, followed by publisher, author, year, subject, isbn, language, num of pages, and price (see sample). Do not forget that subject must use the code as stated in <?= Html::a('LCC', 'http://en.wikipedia.org/wiki/Library_of_Congress_Classification', ['target' => '_blank']) ?>.</p>

<p>After you format it that way, use "Save As", and pick ".csv format". Then upload to the website using the field below.</p>

<?php
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

echo $form->field($model, 'file')->fileInput();
echo Html::submitButton("<span class=\'fa fa-upload\'></span> Import Data", ['class' => 'btn btn-primary']);

ActiveForm::end();
?>