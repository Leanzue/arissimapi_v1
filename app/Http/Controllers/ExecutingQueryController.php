<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExecutingQueryController extends Controller
{
// une méthode pour exécuter une requête SELECT
public function selectQuery($table, $id)
{
$results = DB::table($table)->where('id', $id)->get();
return response()->json($results);
}

// une méthode pour exécuter une requête INSERT
public function insertQuery(Request $request, $table)
{
$data = $request->all();
$columns = implode(", ", array_keys($data));
$placeholders = array_fill(0, count($data), '?');
$values = array_values($data);

DB::table($table)->insert(array_combine(array_keys($data), $values));
return response()->json(['message' => 'Record inserted successfully']);
}

// une méthode pour exécuter une requête UPDATE
public function updateQuery(Request $request, $table, $id)
{
$data = $request->all();
$columns = array_keys($data);
$placeholders = implode(" = ?, ", $columns) . " = ?";
$values = array_values($data);

DB::table($table)->where('id', $id)->update(array_combine($columns, $values));
return response()->json(['message' => 'Record updated successfully']);
}

// une méthode pour exécuter une requête DELETE
public function deleteQuery($table, $id)
{
DB::table($table)->where('id', $id)->delete();
return response()->json(['message' => 'Record deleted successfully']);
}
}
