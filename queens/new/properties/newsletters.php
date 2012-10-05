<div class="wrap">
<?
pr_m_('Newsletters','','h2');
?>
</div>
<?
if (isset($_POST['submit']) and isset($_POST['pr_nwsltr_type']))
{
  pr_send_newsletter();
}
pr_newsletters_form();
?>