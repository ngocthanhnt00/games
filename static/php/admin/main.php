<?php
require_once './static/model/cart.php';
require_once './static/model/connectdb.php';
require_once './static/model/account.php';
require_once './static/model/product.php';
$item_per_page = 10; 
$current_page = 1;
$orders = getAllOrders();
$customer_list=findAllCustomer();
$product_list=findAllProduct($item_per_page, $current_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .tittle-dboard {
            padding-left: 50px;
        }

        .main-content {
            display: flex;
        }

        .game-table {
            flex: 1;
            padding: 0 15px;
            margin-right: 50px;
            margin-top: 50px;
            box-sizing: border-box;
            width: 40%;
        }
        .game-table td{
            padding-bottom: 40px;
        }
        
        .right-table {
            flex: 1;
            padding: 0 15px;
            box-sizing: border-box;
            width: 40%;
            margin-right: 50px;
            margin-top: 50px;

        }

        .cart-chat h4,
        .cart-chat button {
            vertical-align: middle;
        }

        .cart-chat button {
            display: inline;
            background-color: #007bff; /* Màu xanh dương */
            color: white;
            padding: 10px 20px; /* Kích thước nút */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px; 
        }

        .cart-chat button a {
            text-decoration: none; 
            /* Text decoration */
            color: inherit; 
            /* Giữ màu của button */
        }

        .tittle-table {
            display: flex; 
            /* Sử dụng Flexbox */
            flex-direction: row; 
            /* Sắp xếp theo hàng ngang */
        }

        .tittle-table h4,
        .tittle-table button {
            align-self: flex-start; 
        }

        .tittle-table button {
            margin-left: auto; 
        }
    </style>



</head>
<body>
    <h2 class="tittle-dboard">Dashboard</h2>
    <div class="main-content">
        <div class="game-table">
            <div class="cart-chat">
                <div class="tittle-table">
                <h4> Game  Popular</h4>
                <button><a href="?act=dashboard&pg=product_list">View</a></button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Game Id</th>
                            <th>Game Name</th>
                            <th>Price</th>
                            <th>Sale</th>
                            <th>Tag</th>
                        </tr>
                        <td colspan="5">
                        <hr class="divider">
                      </td>
                    </thead>
                    <tbody>
                        
                    <?php
                    // Gọi hàm để lấy danh sách game bán chạy nhất
                    $games = getTopSellerGames();

                    // Duyệt qua danh sách game và hiển thị lên bảng
                    foreach ($games as $game) {
                        echo "<tr>";
                        echo "<td>x" . $game['gameid'] . "</td>";
                        echo "<td>" . $game['gamename'] . "</td>";
                        echo "<td>". number_format($game['price']) . "đ</td>";
                        echo "<td>" . $game['sale'] . "</td>";
                        echo "<td>" . $game['tag'] . "</td>";
                        echo '<tr><td colspan="5"><hr class="divider"></td></tr>'; 

                    }
                    
                    ?>
                    
                    </tbody>
                    
                </table>
                
            </div>
        </div>
    
        <div class="right-table">
            <div class="col-md-9">
                <div class="cart-chat">
                <div class="tittle-table">
                    <h4>New order</h4>
                    <button><a href="?act=dashboard&pg=order_list">View</a></button>
                </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Code order</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <hr class="divider">
                                </td>
                            </tr>
                            <?php foreach($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['cartid']; ?></td>
                                <td><?php echo $order['status']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr class="divider">
                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        
            <div class="col-md-9">
                <div class="cart-chat">
                <div class="tittle-table">
                    <h4>New account</h4>
                    <button><a href="?act=dashboard&pg=account">View</a></button>
                </div>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Display Name</th>
                                <th>Email</th>
                                <th>Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php foreach($customer_list as $customer): ?>
                                <tr>
                                    <td><?php echo $customer['accountid']; ?></td>
                                    <td><?php echo $customer['displayname']; ?></td>
                                    <td><?php echo $customer['email']; ?></td>
                                    <td><?php echo $customer['password']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <hr class="divider">
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
