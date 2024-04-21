<?php
class dongvat
{
    public $ten;
    public $hanhdong;
    function thuoctinh()
    {
        return "Kiem tra";
    }
    function printer() {
        $s = $this->ten;
        $s .= $this->hanhdong;
        return $s;
    }
}
$concho = new dongvat();
$concho->ten = "Mickey";
$concho->hanhdong = "dang an";
echo $concho->thuoctinh();

echo $concho->printer();

// $concho = new dongvat();

// echo $concho->ten;
