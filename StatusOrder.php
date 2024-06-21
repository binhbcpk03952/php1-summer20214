<?php
    class Status {
        public function status($num) {
            switch($num) {
                case 1:
                    echo "<span class='text-dark fw-bold fs-6'>Dang cho xac nhan</span>";
                    break;
                case 2:
                    echo "Da thanh toan, Dang cho xac nhan";
                    break;
                case 3:
                    echo "Shop dang chuan bi hang";
                    break;
                case 4:
                    echo "Don hang dang duoc giao den ban";
                    break;
                case 5:
                    echo "Giao hang thanh cong";
                    break;
                case 6:
                    echo "<span class='text-danger fs-4'>Giao hang that bai</span>";
                    break;
                case 7:
                    echo "<span class='text-danger fw-bold fs-6'>Don hang da bi huy</span>";
                    break;
            }
        }
    }
?>