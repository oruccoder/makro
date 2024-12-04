<?php

/**
 * Urunlerin listesi, urun detayi ve stok durum kontrolu yapar.
 *
 * @author mustafa.kirimli
 * @version 1.0
 */
class Products {

  /**
   * Tum notebooklari dondurur
   * @return array notebook listesi
   */
  public function getAllNotebooks() {
    
    $notebooks = array();
    $notebooks[] = array("code" => "123456", "brand" => "ASUS");
    $notebooks[] = array("code" => "123457", "brand" => "LENOVO");
    $notebooks[] = array("code" => "123458", "brand" => "TOSHIBA");

    return $notebooks;
  }

  /**
   * Notebook stok kontrolu yapar.
   * @param integer $notebookCode notebook code
   * @return string notebook urun stok durumu
   */
  public function checkNotebookStatus($notebookCode) {
    $nbStatus = array("123456" => "VAR", "123458" => "YOK");
    if (array_key_exists($notebookCode, $nbStatus)) {
      return $nbStatus[$notebookCode];
    } else {
      throw New SoapFault("Notebook bulunamadı!", 8);
    }
  }

  /**
   * Tum kitaplari dondurur
   * @return array kitap (book) listesi
   */
  public function getAllBooks() {
    $books = array();
    $books[] = array("ISBN" => "9781234567890",
                     "author" => "Ahmet AY");
    $books[] = array("ISBN" => "9781234567891",
                     "author" => "Mehmet YILDIZ");
    $books[] = array("ISBN" => "9781234567892",
                     "author" => "Ali YILMAZ");
    return $books;
  }


  /**
   * Kitap stok kontrolu yapar.
   * @param string $ISBN ISBN no
   * @return string kitap urun stok durumu
   */
  public function checkBookStatus($ISBN) {
    $bookStatus = array("9781234567890" => "VAR",
                        "9781234567891" => "YOK");
    if (array_key_exists($ISBN, $bookStatus)) {
      return $bookStatus[$ISBN];
    } else {
      throw New SoapFault("Kitap bulunamadı!", 9);
    }
  }

}

?>
