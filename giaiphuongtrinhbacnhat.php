<?php
function giaiPhuongTrinhBacNhat($a, $b)
{
    if ($a != 0) {
        return "Phương trình có nghiệm duy nhất x = " . (-$b / $a);
    } elseif ($b != 0) {
        return "Phương trình vô nghiệm.";
    } else {
        return "Phương trình có vô số nghiệm.";
    }
}

// Ví dụ 
echo giaiPhuongTrinhBacNhat(2, 4) . "<br>";   
echo giaiPhuongTrinhBacNhat(0, 5) . "<br>";   
echo giaiPhuongTrinhBacNhat(0, 0) . "<br>";   
?>