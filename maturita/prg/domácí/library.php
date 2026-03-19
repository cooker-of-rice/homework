<?php
class book{
    public string $name;
    public int $pageCount;
    public bool $isBorrowed;

    public function __construct(string $name, int $pageCount, bool $isBorrowed) {
        $this->name = $name;
        $this->pageCount = $pageCount;
        $this->isBorrowed = $isBorrowed;
    }
}
$library=[
    new book("Harry Potter", 450, false),
    new book("Pán Prstenů", 1200, true),
    new book ("Malý Princ", 96, false),
];
$longest= $library[0];
    foreach ($library as $book){
        if ($book->pageCount>$longest->pageCount){
            $longest=$book;
        }
    }  
echo $longest->name . "is the longest."."(". $longest->pageCount. ")";
   
$json=json_encode($library, JSON_PRETTY_PRINT);
file_put_contents("library.json", $json);
?>