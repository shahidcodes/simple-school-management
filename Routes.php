<?php

require 'App.php';
getNavbar();
getHeader();
if (Admin::isLoggedIn()) {
	$edit = 0;
	if (Input::exists() || Input::exists("get")) {
		$action = Input::get("action");
		$edit 	= !empty(Input::get("r_id"));
		if ($action != "") {
			switch ($action) {
				case 'add':
					$route_name = Input::get("route_name");
					$route_desc	= Input::get("route_desc");
					$route_fee	= Input::get("route_fee");
					$route = new Route();
					if ($route->addRoute(["route_name"=>$route_name, "route_desc"=>$route_desc, "route_fee"=>$route_fee])){
						echo getAlert("Added Successfully");
					}
					break;
				case 'edit':
					$route_name = Input::get("route_name");
					$route_desc	= Input::get("route_desc");
					$route_fee	= Input::get("route_fee");
					$r_id		= Input::get("r_id");
					$route = new Route();
					if ($route->updateRoute($r_id, ["route_name"=>$route_name, "route_desc"=>$route_desc, "route_fee" => $route_fee])){
						Session::flash("msg",getAlert("Route Updated Successfully"));
					}
					break;
				case 'delete':
					$id = Input::get("r_id");
					$route = new Route($id);
					$route->delete();
					echo getAlert("Deleted!");
					$edit=false;
					break;
				default:
					# code...
					break;
			}
			
		}
	}
?>
<?php echo Session::flash("msg") ?>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1>List Of Routes:</h1>
		</div>
		<div class="panel-body">
			<table class="table table-primary">
				<thead>
					<tr>
					<th>Route</th>
					<th>Description</th>
					<th>Fee</th>
					<th>Operation</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(!$edit){
					$route = new Route();
					$routes = $route->getAll();
					foreach ($routes as $r) {
						echo "<tr>
							<td>$r->route_name
							</td>
							<td>$r->route_desc</td>
							<td>$r->route_fee</td>
							<td>
							<a class='btn btn-sm btn-info' href='Routes.php?r_id=$r->id'>Edit</a> -
							<a class='btn btn-sm btn-danger' href='Routes.php?action=delete&r_id=$r->id'>Delete</a>
							</td>
							</tr>";
					}
				}elseif ($edit) {
					$r_id	= Input::get("r_id");
					$route = new Route($r_id);
					echo "<tr>
							<td>{$route->data()->route_name}</td>
							<td>{$route->data()->route_desc}</td>
							<td>{$routes->data()->route_fee}</td>
							<td><a class='btn btn-sm btn-info' href='Routes.php?r_id={$route->data()->id}'>Edit</a> -
							<a class='btn btn-sm btn-info' href='Routes.php?action=delete&r_id={$route->data()->id}'>Delete</a>
							</td>
						</tr>";
				}
				?>
				</tbody>
			</table>
		</div>
		<?php
		if ($edit) {
			$r_id	= Input::get("r_id");
			$route = new Route($r_id);
			$data = $route->data();
		}
		?>
		<div class="panel-footer">
			<form class="form-inline" role="form" action="Routes.php<?=($edit)?"?r_id=$r_id":""?>" method="POST">
			<input type="hidden" name="action" value="<?=($edit)?"edit":"add"?>" />
				<div class="form-group">
					<input type="text" class="form-control" name="route_name" <?=($edit)?"value='$data->route_name'":""?> placeholder="Route Name....">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="route_desc" <?=($edit)?"value='$data->route_desc'":""?> placeholder="Add Route Information Here ..." />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="route_fee" <?=($edit)?"value='$data->route_fee'":""?> placeholder="Fee" />
				</div>
				<input type="submit" class="btn btn-sm btn-success" value="<?=($edit)?"Update":"Add"?> Route" />
			</form>
		</div>
	</div>
</div>
<?php
}else{
	Redirect::to("Dash");
}
?>
</div>
</body>
</html>