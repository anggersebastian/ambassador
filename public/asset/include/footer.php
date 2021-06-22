	<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-3">
				<p>&copy; <?php echo date("Y"); ?> PT Edrus Global Distribusi</p>
				<p><a href="">terms</a> / <a href="">privacy</a> / <a href="">returns</a> / <a href="">delivery</a></p>
			</div> <!-- //end span3 -->
			<div class="col-sm-6 col-md-3">
				<p>Why us?</p>
				<p><a href="about.html">about</a> / <a href="contact.html">contact</a> / <a href="">promotions</a> / <a href="">press</a></p>
			</div> <!-- //end span3 -->
			<div class="col-sm-6 col-md-3">
				<p>Social links</p>
				<p><a href="">Facebook</a> / <a href="">Twitter</a> / <a href="">Pinterest</a></p>
			</div> <!-- //end span3 -->
			<div class="col-sm-6 col-md-3">
				<p>Cari produk</p>
				<form class="form-inline" method="post" action="newsletter-signup.php">
					<input id="newsletter-email" name="newsletter-email" type="text" placeholder="Cari produk..." class="form-control">
					<input name="submit" type="submit" value="&rarr;" class="btn">
				</form>
			</div> <!-- //end span3 -->						
		</div>
	</div>
</footer>	

<script type="text/javascript">
		function addToCart(e) {
			var form = $(e.target).parent();
			var data = {};
			form.serializeArray().map(function(x){data[x.name] = x.value;}); 
			$.ajax({
				url: form.attr("action"),
				type: "post",
				dataType : "json",
				data: data,
				success : function(data){
					console.log(data);
					getCart();
				}
			});
			return false;
		}

		function getCart(){
			$.ajax({
				url : '<?php echo base_url("catalog/get_cart") ?>',
				dataType : 'json',
				success : function(data){
					$(".basket-count").html(data.total_item);
				}
			});
		}

		getCart();
	</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/58d0b9bc78d62074c0a820ae/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>