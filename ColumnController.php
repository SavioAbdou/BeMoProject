<?php

public function delete(Request $request)
{
    // Validate the request data
    $request->validate([
        'id' => 'required|integer'
    ]);

    // Find the column to delete
    $column = Column::find($request->id);

    // Delete the column
    $column->delete();

    // Return a success response
    return response()->json([
        'success' => true
    ]);
}

public function create(Request $request)
{
    // Validate the request data
    $request->validate([
        'title' => 'required|string|max:255'
    ]);

    // Create a new column
    $column = new Column();
    $column->title = $request->title;
    $column->save();

    // Return a success response
    return response()->json([
        'success' => true,
        'column' => $column
    ]);
}

public function update(Request $request, Column $column)
{
    // Validate the request data
    $request->validate([
        'title' => 'required|string|max:255'
    ]);

    // Update the column
    $column->title = $request->title;
    $column->save();

    // Return a success response
    return response()->json([
        'success' => true,
        'column' => $column
    ]);
}

public function index()
{
    // Get all columns from the database
    $columns = Column::with('cards')->get();

    // Return the columns as a JSON response
    return response()->json([
        'columns' => $columns
    ]);
}
