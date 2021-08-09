<?php

namespace Kaushal\Crud\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrudController extends Controller
{

public function GenerateCrud(Request $request){

	  $basePath = base_path();
		$crudName = $request->crudName;
	 	$fields = $request->fields;
    $Migrate = $request->run_migration;

		$crudName = str_replace(' ', '', $crudName);
		$crudName = ucwords(strtolower($crudName));
	  $lastChar =	substr($crudName, -1);
    if($lastChar == "s"){
		  $crudName = substr_replace($crudName ,"",-1);
		}
    
    try {
      $allFields = explode(',',$fields);
   
      foreach($allFields as $key => $value){
        $fieldsAndDataType  =  explode('#', $value); 
        $tableFields[$fieldsAndDataType[0]] = $fieldsAndDataType[1];
      }

    } catch (\Throwable $th) {
     return $messages['FieldsError'] = "Entered table fields does not match the requirement";
    }
    
    
    $messages['Modeloutput'] = $this->MakeModel($basePath, $crudName);
    $date = date('y-m-d');
    $date = explode('-', $date);
    $migration_file = $date[0] ."_". $date[1] ."_".$date[2]."_".rand()."_create_".strtolower($crudName)."s_table";
    $messages['Migration'] =  $this->MakeMigration($basePath, $tableFields, $crudName, $migration_file);
     
    if($Migrate == '1'){
      $messages['Migrationoutput'] = $this->Migrate( $basePath, $migration_file);
    }

    $messages['Controlleroutput'] =  $this->MakeResourceController($basePath, $tableFields, $crudName );
    $messages['ViewMessage'] =  $this->MakeViewsFiles($basePath, $tableFields, $crudName);
    $messages['RouteMessage'] = $this->MakeRoute($basePath, $crudName);
    return view('crud::createCrud', ['messages' => $messages ] );

  }


/*|=============================================================================|
  |                            Make A Model                                     |
  |=============================================================================|
*/

public function MakeModel($basePath, $crudName ){

  $ModelCommand = "php artisan make:model ".$crudName;
  $Modeloutput = shell_exec('cd '.$basePath.' && '.$ModelCommand);
  return  $Modeloutput;

}


/*|=============================================================================|
  |                            Make A Migration Table                           |
  |=============================================================================|
*/

public function MakeMigration($basePath, $tableFields, $crudName,$migration_file){

$tableData = "";
foreach($tableFields as $column => $datatype){
 $tableData .= "$"."table->".$datatype."('".$column."');".PHP_EOL;
 }
 
$migrationText="<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create".$crudName."sTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
  Schema::create('".strtolower($crudName)."s', function (Blueprint "."$"."table) {
  "."$"."table->increments('id');
  ".$tableData."
   "."$"."table->timestamps();
  });
}
 
/**
* Reverse the migrations.
*
 * @return void
*/
public function down()
{
     Schema::dropIfExists('".strtolower($crudName)."s');
}
}
";


$filePath = $basePath."/database/migrations/".$migration_file.".php";
$migrationFile = fopen($filePath, "w") or die("Unable to open file!");
fwrite($migrationFile, $migrationText);
fclose($migrationFile);
 return "database/migrations/create_".$crudName."s_table.php created successfully";

}


/*|=============================================================================|
  |                            Run the Migration                                |
  |=============================================================================|
*/

public function Migrate( $basePath, $migration_file){

$MigrateCommand  = "php artisan migrate:refresh --path=/database/migrations/".$migration_file.".php";
$Migrationoutput = shell_exec('cd '.$basePath.' && '.$MigrateCommand); 
return  $Migrationoutput;
}


/*|=============================================================================
  |                            Create A Resource Controller                    |
  |=============================================================================
*/


public function MakeResourceController($basePath, $tableFields, $crudName ){


$FieldsToValidate= "";
foreach($tableFields as $column => $datatype){
		$FieldsToValidate .= nl2br("'".$column."' => 'required|max:255', ");
 }   

 $FieldsToStore = "";
 foreach($tableFields as $column => $datatype){
	$FieldsToStore .= nl2br(""."$"."data->".$column." = "."$"."request->".$column."; ");
}


$FieldsToUpdate = "";
$FieldsToUpdate = "";
foreach($tableFields as $column => $datatype){
   $FieldsToUpdate .= nl2br("'".$column."' => "."$"."request->".$column.", ");
}

$modelname = "App\Models\ ".$crudName."";
$modelname = str_replace(' ', '',$modelname);

$controllerText = "
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use ".$modelname.";
use validate;

class ".$crudName."Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$".$crudName."sDataForIndex = ".$crudName."::orderBy('created_at', 'DESC')->paginate(10);
        return view('".$crudName."s.index',compact('".$crudName."sDataForIndex'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('".$crudName."s.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  "."$"."request
     * @return \Illuminate\Http\Response
     */
    public function store(Request "."$"."request)
    {
		"."$"."data = new ".$crudName."();

		"."$"."this->validate("."$"."request, [
			".$FieldsToValidate."
		]);

		".$FieldsToStore."

		"."$"."data->save();
		return redirect()->back()->with('success_message', 'Saved Successfully');
	
    }

    /**
     * Display the specified resource.
     *
     * @param  int  "."$"."id
     * @return \Illuminate\Http\Response
     */
    public function show("."$"."id)
    {
		"."$"."show".$crudName." = ".$crudName."::where('id', "."$"."id)->first();
        return view('".$crudName."s.show', compact('show".$crudName."'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int "."$"."id
     * @return \Illuminate\Http\Response
     */
    public function edit("."$"."id)
    {
		"."$"."edit".$crudName." = ".$crudName."::where('id', "."$"."id)->first();
         return view('".$crudName."s.edit', compact('edit".$crudName."'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  "."$"."request
     * @param  int  "."$"."id
     * @return \Illuminate\Http\Response
     */
    public function update(Request "."$"."request, "."$"."id)
    {
        ".$crudName."::where('id', "."$"."id)->update([
           ".$FieldsToUpdate."
        ]);
        return redirect()->back()->with('success_message', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int "."$"."id
     * @return \Illuminate\Http\Response
     */
    public function destroy("."$"."id)
    {
		"."$"."delete".$crudName." = ".$crudName."::find("."$"."id);    
		"."$"."delete".$crudName."->delete();
		return redirect()->back()->with('success_message', 'Deleted Successfully');
    }
} 

";
      $filePath = $basePath."/app/Http/Controllers/".$crudName."Controller.php";
      $ControllerFile = fopen($filePath, "w") or die("Unable to open file!");
	    fwrite($ControllerFile, $controllerText);
      fclose($ControllerFile);
	    return "Controller Created Successfully";

}

/*|=============================================================================|
  |                              Create  View Files                             |
  |=============================================================================|
*/

public function MakeViewsFiles($basePath, $tableFields, $crudName){

// ----------------Create Directory 
$viewdirectoryoutput = shell_exec('cd '.$basePath.'/resources/views'.' && mkdir '.$crudName.'s');
$messages['Viewdirectoryoutput'] = $viewdirectoryoutput;

// ----------------Create A Index.blade.php File
$tableHeading = "";
foreach($tableFields as $column => $datatype){
     $tableHeading .= nl2br("<th scope='col'>".$column."</th>");
}

 $tableData = "";
foreach($tableFields as $column => $datatype){
      $tableData .= nl2br("<td>{{ "."$"."value->".$column." }}</td>");
  }

$indexText ="
<!-- Bootstrap 4.4 frameworked is used -->
@extends('layouts.YourLayoutName')
@section('content')
<h3 class='text-center'>List ".$crudName."s</h3>
@if(count($".$crudName."sDataForIndex) > 0 )
   <table class='table'>
   <thead>
     <tr>
     <th scope='col'>#</th>
     ".$tableHeading."
     <th scope='col'>Action</th>
     </tr>
   </thead>
   <tbody>
@foreach($".$crudName."sDataForIndex as "."$"."key => "."$"."value)
     <tr>
     <th scope='row'>{{ "."$"."loop->index+1 }}</th>
     ".$tableData."
      <td>
        <a href='{{ route('".$crudName.".show',"."$"."value->id ) }}'>Show</a>
        <a href='{{ route('".$crudName.".edit',"."$"."value->id ) }}'>Edit</a>
      <form action='{{ route('".$crudName.".destroy',"."$"."value->id ) }}' method='POST'>
@csrf
@method('DELETE')
         <button class='btn btn-danger'>Delete</button>
       </form>
      </td>
     </tr>
@endforeach
   </tbody>         
   </table>
@else
     <h2 class='text-center'>No Data Found</h2>
@endif
   {{ $".$crudName."sDataForIndex->links() }}
@endsection";

$filePath = $basePath."/resources/views/".$crudName."s/index.blade.php";
$indexFile = fopen($filePath, "w") or die("Unable to open file!");
fwrite($indexFile, $indexText);
fclose($indexFile);



// ----------------Create A Create.blade.php File

$FormFields= "";
foreach($tableFields as $column => $datatype){
 $FormFields .= nl2br("<div class='form-group'><label for='".$column."label'>".$column."</label><input type='text' name='".$column."' class='form-control' id='".$column."label'></div>");
}

$createText = "
@extends('layouts.YourLayoutName')
@section('content')
<h3 class='text-center'>Create ".$crudName."</h3>
<hr/>
<form method='post' action='{{ route('".$crudName.".store') }}' enctype='multipart/form-data'>
@csrf
 ".$FormFields."
 <button type='submit' class='btn btn-primary'>Submit</button>
</form>
@endsection";
        
$filePath = $basePath."/resources/views/".$crudName."s/create.blade.php";
$createFile = fopen($filePath, "w") or die("Unable to open file!");
fwrite($createFile, $createText);
fclose($createFile);



// ----------------Create A Show.blade.php File

$ShowData = "";
  foreach($tableFields as $column => $datatype){
      $ShowData .= nl2br("{{ $"."show".$crudName."->".$column." }} ");
  }

$showText = "
@extends('layouts.YourLayoutName')
@section('content')
<h3 class='text-center'>Show ".$crudName."</h3>
<hr/>
  ".$ShowData."
@endsection";

$filePath = $basePath."/resources/views/".$crudName."s/show.blade.php";
$showFile = fopen($filePath, "w") or die("Unable to open file!");
fwrite($showFile, $showText);
fclose($showFile);

$messages['Showview'] = "resources/views/".$crudName."s/show.blade.php created successfully ";


// ----------------Create A Edit.blade.php File

$editFields = "";
foreach($tableFields as $column => $datatype){
      $editFields .= nl2br("<div class='form-group'><label for='".$column."label'>".$column."</label><input type='text' name='".$column."' value='{{ "."$"."edit".$crudName."->".$column." }}' class='form-control' id='".$column."label'></div>");
}

$editText = "
@extends('layouts.YourLayoutName')
@section('content')
<h3 class='text-center'>Edit ".$crudName."</h3>
<hr/>
<form method='post' action='{{ route('".$crudName.".update', "."$"."edit".$crudName."->id ) }}' enctype='multipart/form-data'>
@csrf
@method('PUT')

".$editFields."
  <button type='submit' class='btn btn-primary'>Submit</button>
</form>
@endsection";

$filePath = $basePath."/resources/views/".$crudName."s/edit.blade.php";
$editFile = fopen($filePath, "w") or die("Unable to open file!");
fwrite($editFile, $editText);
fclose($editFile);

return "resources/views/".$crudName."s/ Index,Create,Show,Edit Files Created";

}

 /*|=============================================================================|
   |                              Create A Route                                 |
   |=============================================================================|
*/


public function MakeRoute($basePath, $crudName){

$route = " use App\Http\Controllers\ ".$crudName."Controller;".PHP_EOL."Route::resource('".$crudName."',".$crudName."Controller::class);".PHP_EOL;
$filePath = $basePath."/routes/web.php";
$routeFile = fopen($filePath, "a") or die("Unable to open file!");
fwrite($routeFile, $route);
fclose($routeFile);

return  "Route Generated !" . $route;

}

}
