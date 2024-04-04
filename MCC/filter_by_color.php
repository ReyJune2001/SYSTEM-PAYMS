<?php
include 'connect.php';

$paintColor = $_GET['color'];

$sql = "SELECT 
            paint.paint_color,
            SUM(entry.paintYield) AS total_paint_yield,
            SUM(entry.acetateYield) AS total_acetate_yield
        FROM tbl_entry AS entry
        LEFT JOIN tbl_paint AS paint ON entry.paintID = paint.paintID
        WHERE paint.paint_color = '$paintColor'
        GROUP BY paint.paint_color
        ORDER BY total_paint_yield DESC, total_acetate_yield DESC";

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($selected = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $selected['paint_color'] . '</td>';
        echo '<td>' . $selected['total_paint_yield'] . '</td>';
        echo '<td>' . $selected['total_acetate_yield'] . '</td>';
        echo '</tr>';
    }
} else {
    echo "<tr><td colspan='3'>No data found</td></tr>";
}
?>
