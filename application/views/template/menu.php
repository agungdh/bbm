		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">

			<li class="header">MENU UTAMA</li>

			<li class="treeview">
				<a href="#"><i class="fa fa-calculator text-aqua"></i> <span>Transaksi BBM</span> <i class="fa fa-angle-left pull-right"></i></a>
		          <ul class="treeview-menu">
		            <li><a href="<?php echo base_url('spp')?>"><i class="fa fa-book text-aqua"></i> Surat Pengiriman (SPP)</a></li>
		            <li><a href="<?php echo base_url('invoice')?>"><i class="fa fa-book text-aqua"></i> Invoice</a></li>
		            <li><a href="<?php echo base_url('penawaran')?>"><i class="fa fa-book text-aqua"></i> Data Penawaran</a></li>
		            <li><a href="<?php echo base_url('input_bbm')?>"><i class="fa fa-book text-aqua"></i> Input BBM</a></li>
		          </ul>
			</li>		

			<li class="treeview">
				<a href="#"><i class="fa fa-print text-aqua"></i> <span>Laporan </span> <i class="fa fa-angle-left pull-right"></i></a>
		          <ul class="treeview-menu">
		            <li><a href="<?php echo base_url('laporan')?>"><i class="fa fa-map-o text-aqua"></i> Data Tagihan</a></li>
		            <li><a href="<?php echo base_url('laporan/stok')?>"><i class="fa fa-map-o text-aqua"></i> Data Stok BBM</a></li>
		            <li><a href="<?php echo base_url('laporan/masuk')?>"><i class="fa fa-map-o text-aqua"></i> Data BBM Masuk</a></li>
		            <li><a href="<?php echo base_url('laporan/keluar')?>"><i class="fa fa-map-o text-aqua"></i> Data BBM Keluar</a></li>
		          </ul>
			</li>		

			<li class="treeview">
				<a href="#"><i class="fa fa-database text-aqua"></i> <span>Master Data </span> <i class="fa fa-angle-left pull-right"></i></a>
		          <ul class="treeview-menu">
		            <li><a href="<?php echo base_url('konsumen')?>"><i class="fa fa-cubes text-aqua"></i> Data Konsumen</a></li>
		            <li><a href="<?php echo base_url('kendaraan')?>"><i class="fa fa-cubes text-aqua"></i> Data Kendaraan</a></li>
		            <li><a href="<?php echo base_url('sopir')?>"><i class="fa fa-cubes text-aqua"></i> Data Sopir</a></li>
		          </ul>
			</li>		

	<?php
	if ( $this->session->level == '0' )
	{ ?>			
			<li class="treeview">
				<a href="#"><i class="fa fa-dot-circle-o text-aqua"></i> <span>Administrator</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
		            <li><a href="<?php echo base_url("profil/user"); ?>"><i class="fa fa-user text-aqua"></i> Entri User</a></li>
				</ul>
			</li>
	<?php } ?>

		</ul><!-- /.sidebar-menu -->
