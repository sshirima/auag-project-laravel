<?php

namespace App\Http\Controllers;

use App\Command;
use Illuminate\Http\Request;

class CommandController extends Controller {

    public function getCommandsView() {
        
    }

    public function postAddCommand(Request $request) {
        $this->validate($request, [
            'code' => 'required|unique:commands',
            'description' => 'required',
            'members_col' => 'required',
        ]);
        $message = 'FAIL';

        $command = new Command();
        $command->code = $request['code'];
        $command->description = $request['description'];
        $command->members_col = $request['members_col'];
        $command->message = $request['message'];

        if ($command->save()) {
            $message = 'OK';
        }

        return response()->json(['status' => $message]);
    }

    public function postUpdateCommand(Request $request) {
        $this->validate($request, [
            'id' => 'required',
            'code' => 'required',
            'description' => 'required',
            'members_col' => 'required',
        ]);
        $message = 'FAIL';
        $command = Command::find($request['id']);

        $command->code = $request['code'];
        $command->description = $request['description'];
        $command->members_col = $request['members_col'];
        $command->message = $request['message'];

        if ($command->update()) {
            $message = 'OK';
        }
        return response()->json(['status' => $message]);
    }

    public function postGetAllCommands() {
        $members = Command::all();
        return $members;
    }

    public function postDeleteCommand(Request $request) {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $submitedId = $request['id'];

        $command = Command::find($submitedId);
        return $command->delete();
    }

}
