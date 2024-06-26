<?php
// session_start();
include_once "./static/model/connectdb.php";
include_once "./static/php/admin/header.php";
include_once './static/model/category.php';
include_once './static/model/product.php';
include_once './static/model/cart.php';
include_once './static/model/customer.php';

if (isset($_GET['pg'])) {
    switch ($_GET['pg']) {
        case 'database':
            include_once './static/php/admin/main.php';
            break;
        case 'category_list':
            $category_list = findAllCategory();
            include_once './static/php/admin/category_list.php';
            break;
        case 'category_add':
            if (isset($_POST['addCategory_submit'])) {

                $categoryName = $_POST['categoryName'];


                $success = addCategory($categoryName);

                // thêm danh mục thành công thì chuyển hướng về category_list
                if ($success) {
                    header("Location: ?act=dashboard&pg=category_list");
                    exit;
                }
            }
            include_once './static/php/admin/category_add.php';
            break;
        case 'delete_category':
            if (isset($_GET['id'])) {
                $genreid = $_GET['id'];
                $success = deleteCategory($genreid);
                if ($success) {
                    header("Location: ?act=dashboard&pg=category_list");
                    exit;
                }
            }
            break;
        case 'category_edit':
            if (isset($_GET['id'])) {
                $genreid = $_GET['id'];
                // Lấy dữ liệu của danh mục từ cơ sở dữ liệu
                $category = getCategoryById($genreid);
                if ($category) {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $categoryName = $_POST['categoryName'];
                        if ($_FILES['categoryImage']['error'] == UPLOAD_ERR_OK) {
                            $categoryImage = $_FILES['categoryImage']['name'];
                            $tempName = $_FILES['categoryImage']['tmp_name'];
                            $destination = "./img/genre-img/" . $categoryImage;
                            move_uploaded_file($tempName, $destination);
                        } else {
                            // Nếu không có tệp tin được tải lên, sử dụng hình ảnh cũ
                            $categoryImage = $category['img'];
                        }
                        $success = editCategory($genreid, $categoryName, $categoryImage);
                        if ($success) {
                            header("Location: ?act=dashboard&pg=category_list");
                            exit();
                        } else {
                            echo "Error: Failed to edit category.";
                        }
                    } else {
                        // Hiển thị form chỉnh sửa danh mục với dữ liệu của danh mục được lấy từ cơ sở dữ liệu
                        include_once './static/php/admin/category_edit.php';
                    }
                } else {
                    echo "Category not found!";
                }
            } else {
                echo "Category ID not provided!";
            }
            break;
        case 'account':
            $customer_list = findAllCustomer();
            include_once './static/php/admin/account.php';
            break;
        case 'deletecustomer':
            if (isset($_GET['accountid']) && $_GET['accountid'] >= 0) {
                // Thêm mã để xóa danh mục
                $customer_id = $_GET['accountid'];
                deleteCustomer($customer_id);
                $customer_list = findAllCustomer();
                include_once './static/php/admin/account.php';
            }
            // include_once 'public/form-edit-catalog.php';
            break;
        case 'editcustomer':
            // Kiểm tra xem có truyền accountid từ URL không
            if (isset($_GET['accountid']) && $_GET['accountid'] >= 0) {
                // Lấy accountid từ URL
                $accountid = $_GET['accountid'];

                // Lấy thông tin khách hàng từ cơ sở dữ liệu
                $customer_info = findByIdCustomer($accountid);
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editCustomer'])) {
                    // Lấy thông tin mới từ form
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $displayname = $_POST['displayname'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];

                    // Sử dụng hàm editCustomer để cập nhật thông tin khách hàng
                    $success = editCusomer($accountid, $firstname, $lastname, $displayname, $password, $email);

                    if ($success) {
                        header("Location: index.php?act=dashboard&pg=account");
                        exit(); // Đảm bảo không có mã PHP nào khác được thực thi sau khi chuyển hướng
                    }
                }
                // Include trang sửa thông tin khách hàng
                include_once './static/php/admin/customer_edit.php';
            } else {
                // Nếu không có accountid, chuyển hướng về trang chính
                header("Location: index.php");
            }
            break;
        case 'order_list':
            $orders = getAllOrders();
            include_once './static/php/admin/order_list.php';
            break;
        case 'delete_order':
            if (isset($_GET['id'])) {
                $cartid = $_GET['id']; // Lấy cartid từ URL
                $success = deleteOrder($cartid); // Gọi hàm xóa đơn hàng
                if ($success) {
                    header("Location: ?act=dashboard&pg=order_list"); // Chuyển hướng về trang danh sách đơn hàng nếu xóa thành công
                    exit;
                } else {
                    echo "Failed to delete order."; // Hiển thị thông báo nếu xóa không thành công
                }
            } else {
                echo "Order ID is missing."; // Hiển thị thông báo nếu cartid không được truyền qua URL
            }
            break;
        case 'order_edit':
            if (isset($_GET['id'])) {
                $orderId = $_GET['id'];
                $order = getOrderById($orderId);
                if (!$order) {
                    echo "Order not found.";
                    break;
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $cartid = $_POST['cartid'];
                    $accountid = $_POST['accountid'];
                    $purchasedate = $_POST['purchasedate'];
                    $status = $_POST['status'];
                    $paymentmethod = $_POST['paymentmethod'];
                    $totalprice = $_POST['totalprice'];
                    $success = editOrder($orderId, $cartid, $accountid, $purchasedate, $status, $paymentmethod, $totalprice);
                    if ($success) {
                        header("Location: ?act=dashboard&pg=order_list");
                        exit;
                    } else {
                        echo "Failed to update order.";
                    }
                } else {
                    include_once './static/php/admin/order_edit.php';
                }
            } else {
                echo "Order ID is missing.";
            }
            break;


        case 'product_list':
            include_once './static/php/admin/product.php';
            break;
        case 'product_add':
            // $product_add = addProduct();
            $genre_list = findAllGenre();
            include_once './static/php/admin/product_add.php';
            break;
        case 'product_edit':
            include_once './static/php/admin/product_edit.php';
            break;
        default:
            // Xử lý trường hợp không khớp với bất kỳ case nào (nếu cần)
            include_once './static/php/admin/main.php';
            break;
    }
} else {
    // Xử lý khi $_GET['pg'] không tồn tại
    include_once './static/php/admin/main.php';
}
