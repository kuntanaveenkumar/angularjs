 
    
    <!-- TITLE BAR
	============================================= -->
	<div class="b-titlebar" ng-controller="pagecontentcontroller">
		<div class="layout">
			<!-- Bread Crumbs -->
			<ul class="crumbs">
				<li>You are here:</li>
				<li><a href="<?php echo base_url();?>index">Home</a></li>
				<li><a href="<?php echo base_url();?>about_us" >About Us</a></li>
			</ul>
			<!-- Title -->
			<h1 id="cms_titlear">{{cms_title}}</h1>
		</div>
	</div>
	<!-- END TITLE BAR
	============================================= -->
	<!-- CONTENT 
	============================================= -->
	<div class="content" ng-controller="pagecontentcontroller">
		<div class="layout">
			<div id="pagecontent" class="row-item"  ng-bind-html="cms_desc">	
				{{cms_desc}}
				
			</div>	
		</div>
	</div>
	<!-- END CONTENT 
	============================================= -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
	

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-sanitize.js"></script>>

<script type="text/javascript">
var app= angular.module('app',['ngSanitize']);
/**/
app.controller('pagecontentcontroller', function($scope, $http,$sce) {
	$scope.cms_title ="";
	$scope.cms_desc ="";
	$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
	$http({
    method: 'POST',
    url: "<?php echo base_url();?>cms/cms.json",
    data: $.param({page: '<?php echo $page_name;?>'}),
    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
    .then(function(response) {
        
		 var json = $.parseJSON(JSON.stringify(response['data']));
			 $.each(json, function(idx, obj) 
			 {				
				var cms_title=obj.cms_title;
				var cms_desc=obj.cms_desc;	

				$scope.cms_title =cms_title;
				 $scope.cms_desc = $sce.trustAsHtml(cms_desc);
				
			 });
		
    }, 
    function(response) { // optional
            // failed
    });
	
});

/*
   $(document).ready(function()//When the dom is ready
   {	  
		var flag=0;
		var formData = {page:'<?php echo $page_name;?>'};		
		$.ajax(
		{
		url : "<?php echo base_url();?>cms/cms.json",
		type: "POST",
		data : formData,
		success: function(data, textStatus, jqXHR)
		{

			flag=1;
			var cms_title;
			var cms_desc;

			 var json = $.parseJSON(JSON.stringify(data));
			 $.each(json, function(idx, obj) 
			 {				
				var cms_title=obj.cms_title;
				var cms_desc=obj.cms_desc;	

				$('#cms_title').html(cms_title);
				$('#pagecontent').html(stripslashes(cms_desc));
			 });
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			//alert("Error in loading..");
		}
	});
	if(flag==0)
	   {
			var formData = {page:'<?php echo $page_name;?>'};		
		$.ajax(
		{
		url : "<?php echo base_url();?>cms/footerpage.json",
		type: "POST",
		data : formData,
		success: function(data, textStatus, jqXHR)
		{

			flag=1;
			var cms_title;
			var cms_desc;

			 var json = $.parseJSON(JSON.stringify(data));
			 $.each(json, function(idx, obj) 
			 {				
				var cms_title=obj.cms_title;
				var cms_desc=obj.cms_desc;	
			

				$('#cms_title').html(cms_title);

				$('#pagecontent').html(stripslashes(cms_desc));
			 });
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			//alert("Error in loading..");
		}
	});
	   }
	
});*/
</script>