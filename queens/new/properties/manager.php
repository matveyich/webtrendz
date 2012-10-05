<div class="wrap">
<?
pr_m_('Overview of properties plugin','','h2');
?>
</div>
<?
if (isset($_GET['page_id'])) $page_id = $_GET['page_id']; else $page_id = 1;
pr_general_prop_list($page_id);
?>