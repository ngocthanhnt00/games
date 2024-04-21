<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img src="/static/img/" alt="">
</body>
</html>

<?php
// Hàm để lấy thông tin sản phẩm từ cơ sở dữ liệu dựa trên gameid
function getProductInfoById($gameid)
{
    // Thực hiện kết nối đến cơ sở dữ liệu
    $conn = connectDb();
    // Thiết lập chế độ lỗi để bắt lỗi một cách chính xác
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        // Chuẩn bị truy vấn để lấy thông tin sản phẩm dựa trên gameid
        $stmt = $conn->prepare("SELECT * FROM game WHERE gameid = :gameid");
        $stmt->bindParam(':gameid', $gameid);
        $stmt->execute();

        // Lấy kết quả trả về dưới dạng mảng kết hợp (associative array)
        $product_info = $stmt->fetch(PDO::FETCH_ASSOC);

        // Trả về thông tin sản phẩm
        return $product_info;
    } catch (PDOException $e) {
        // Xử lý lỗi nếu có
        echo "Lỗi: " . $e->getMessage();
        return null;
    }
}

function editImg($gameid)
{
    $conn = connectDb();
    $sql = "SELECT `first-img`, `second-img`, `third-img`, `fourth-img`, `fifth-img`, `icon`, `logo` FROM game WHERE gameid = :gameid";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':gameid', $gameid); // Truyền giá trị cho tham số :gameid
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $conn = null;
    return $data;
}

function handleImage($inputName, $existingImage, $imageType)
{
    $target_dir = './static/img/';
    if (!empty($_FILES[$inputName]['name'])) {
        $image = $_FILES[$inputName]['name'];
        $target_folder = $target_dir . $imageType . "/";
        move_uploaded_file($_FILES[$inputName]["tmp_name"], $target_folder . $image);
        return $image;
    } else {
        return $existingImage;
    }
}

$productImg1 = handleImage('image1', isset($image_edit['first-img']) ? $image_edit['first-img'] : '', "first-img");
$productImg2 = handleImage('image2', isset($image_edit['second-img']) ? $image_edit['second-img'] : '', "second-img");
$productImg3 = handleImage('image3', isset($image_edit['third-img']) ? $image_edit['third-img'] : '', "third-img");
$productImg4 = handleImage('image4', isset($image_edit['fourth-img']) ? $image_edit['fourth-img'] : '', "fourth-img");
$productImg5 = handleImage('image5', isset($image_edit['fifth-img']) ? $image_edit['fifth-img'] : '', "fifth-img");
$productIcon = handleImage('icon', isset($image_edit['icon']) ? $image_edit['icon'] : '', "icon");
$productLogo = handleImage('logo', isset($image_edit['logo']) ? $image_edit['logo'] : '', "logo");
?>