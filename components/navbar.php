<div id="header">
	<div class="container">
			
		<!-- Logo -->
			<div class="row">
				<a href="index.php"><div id="logo" class="3u"><img src="images/logo.jpg"></div></a>
			</div>
		<!-- Nav -->
			<nav id="nav">
				<ul>
				<?php 
					include "php/connect.php";

					$language = $_GET['language'];
					if (strlen($language) > 2) {
						$language = '';
					}
					$result = mysqli_query($con, "SELECT g.* FROM groups g WHERE g.language = '$language'");
					if ($result) {
						while ($row = $result->fetch_object()) {
							print '<li><a href="group.php?id=' . $row->id .'">'. $row->name .'</a></li>';
						}
						$result->close();
					}
				?>
					<!-- <li><p class="tel">(+373) 247 2 24 40</p></li> -->
				</ul>
			</nav>

	</div>
</div>