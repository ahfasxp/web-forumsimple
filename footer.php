			</div>
			<div id="sidebar">
				<?php
				if(empty($_SESSION['signed_in'])){
}else{




				$id=$_SESSION['user_id'];
				$result = mysql_query("SELECT * FROM users WHERE user_id=$id");
				while ($dataxp = mysql_fetch_array($result)) { 
				if ($dataxp['user_level']==1) { 
					?>	
				<div id="admin">
					<h3>Fitur Admin</h3>
					<ul>
						<li><a href="member.php">Daftar Member</a></li>
						<li><a href="postingan.php">Daftar Postingan</a></li>
						<li><a href="komentar.php">Daftar Komentar</a></li>
						<li><a href="kategori.php">Daftar Kategori</a></li>
					</ul>
				</div>
				<?php } } ?>
				<div id="admin">
					<h3>Kategori</h3>
					<ul><?php
						$a="SELECT * FROM kategori";
                  $sql=mysql_query($a);
                  while($data=mysql_fetch_array($sql)){ ?>       
						<li><a href="cat.php?c=<?php echo $data[0]; ?>"><?php echo $data[1]; ?></a></li>
					<?php  }} ?>
					</ul>
				</div>





			</div>
		</div>
		<div id="footer">
			<p><i class="far fa-copyright"> COPYRIGHT 2018 - DISTIN</i></p>
		</div>
	</body>
</html>
