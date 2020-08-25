<?php
if(!(isset($_GET["type"]))) {
    header("Location: ../../recruitment");
}
$type = htmlspecialchars($_GET["type"]);
//include our library and start drawing the page
require_once("../../php_include/functions.php");
$page_name = "postings";
print_header($page_name, false);
print_navbar();
?>

<div class="container">
    <div class="mtt-content">
    <?php
        echo '<h2>' . ucfirst($type) . ' Roles</h2>'
    ?>
    </div>

    <table>
        <tr>
            <th>
                Application
            </th>
            <th>
                Position
            </th>
            <th>
                Number of Roles
            </th>
            <th>
                Project
            </th>
        </tr>
        <?php
            if ($db = get_db()) {
                $query = "SELECT * FROM `" . $type . "_postings`;";
                if ($result = $db->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $position = '<p>' . $row['position'] . '</p>';
                        if (strlen($row['details']) > 0) {
                            $position = '<a href="/recruitment/postings/assets/files/' . $row['details'] . '" download>' . $row['position'] . '</a>';
                        }
                        echo 
                            '<tr>
                                <td>
                                    <a href="https://forms.gle/M2yZpicG4zeLc1k48">
                                        <button>Apply Now</button>
                                    </a>
                                </td>
                                <td>
                                    ' . $position .'
                                </td>
                                <td>
                                    <p>'. $row['role_count'] .'</p>
                                </td>
                                <td>
                                    <a href="' . $row['project_link'] . '">' . $row['project'] . '</a>
                                </td>
                            </tr>';
                    }
                }
            }
        ?>
    </table>
    <br /><br />

    <?php
    print_footnote();
    ?>

</div>
<!--container-->

<?php
//print the footer	
print_footer();
?>