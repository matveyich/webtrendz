<?php
### Check Whether User Can Manage pg-Review
if(!current_user_can('manage_pgr'))
{
  die('Access Denied');
}


### Variables Variables Variables
$base_name = plugin_basename('pg-review/pgr-overview.php');
$base_page = 'admin.php?page='.$base_name;

  ?>
  <div class="table">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tbody>
        <tr class="first">
          <td><h2>PAGE REVIEW Overview</h2></td>
        </tr>
        <tr>
          <td><h3>About</h3></td>
        </tr>
        <tr>
          <td>It's plugin used for compile reviews on site</td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php


/*
//==========================
//===Overview PAGE REVIEW===
//==========================
function pgr_overview()
{
  ?>
  <div class="table">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tbody>
        <tr class="first">
          <td><h2>PAGE REVIEW Overview</h2></td>
        </tr>
        <tr>
          <td><h3>About</h3></td>
        </tr>
        <tr>
          <td>It's plugin used for compile reviews on site</td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

*/