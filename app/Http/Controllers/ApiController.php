<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Username;
use Illuminate\Http\Request;

class ApiController extends Controller
{
//    protected $middleware = ['cors'];

    public function usernamesSearched()
    {
        return Username::where('process_state', 'processed')->count();
    }

    public function evaluateUsernames(Request $request)
    {
        $usernames = $request->get('usernames') ?? [];
        $validUsernames = [];
        foreach ($usernames as $username) {
            if ($this->isUsernameValid($username) && count($validUsernames) < 10) {
                $validUsernames[] = $username;
            }
        }
        if (count($validUsernames) > 0) {
            $batch = Batch::create([
                'name' => 'Test'
            ]);
            $batchID = $batch->id;
            $ret = [
                'usernames' => [],
                'is_processed' => false,
                'id' => $batchID,
                'email' => null
            ];
            $namesToProcess = 0;
            foreach ($validUsernames as $value) {
                $username = Username::where('value', $value)->first();
                if ($username) {
                    $username->batches()->attach($batchID);
                } else {
                    $namesToProcess++;
                    $username = Username::create([
                        'value' => $value
                    ]);
                    $username->batches()->attach($batchID);
                }
                $ret['usernames'][] = [
                    'username' => $username->value,
                    'score' => $username->score
                ];
            }
            //We didn't get any new names, so mark the batch as processed
            if ($namesToProcess === 0) {
                $batch->is_processed = true;
                $batch->save();
            }
            return [
                'data' => $ret,
                'error' => null
            ];
        } else {
            return [
                'error' => 'You did not enter any valid usernames',
                'data' => null
            ];
        }
    }

    public function setBatchEmail($id, Request $request)
    {
        $batch = Batch::find($id);
        if (!$batch) {
            return [
                'error' => 'Batch not found',
                'data' => null
            ];
        }
        if ($batch->email) {
            return [
                'error' => 'Batch already has an assigned email address',
                'data' => null
            ];
        }
        $email = filter_var($request->get('email'), FILTER_VALIDATE_EMAIL);
        if ($email) {
            $batch->email = $email;
            $batch->save();
            return [
                'error' => null,
                'data' => 'Thank you! You will be notified when we are ready!'
            ];
        } else {
            return [
                'error' => 'That email address does not appear to be valid.',
                'data' => null
            ];
        }
    }

    public function getBatch($id)
    {
        $batch = Batch::find($id);
        if (!$batch) {
            return [
                'error' => 'Batch not found',
                'data' => null
            ];
        }
        $usernames = $batch->usernames;
        $ret = [
            'usernames' => [],
            'is_processed' => $batch->is_processed,
            'id' => $batch->id,
            'email' => $batch->email
        ];
        foreach ($usernames as $username) {
            $ret['usernames'][] = [
                'username' => $username->value,
                'score' => $username->score,
                'process_state' => $username->process_state
            ];
        }
        return [
            'data' => $ret,
            'error' => null
        ];
    }

    private function isUsernameValid($username)
    {
        if (strlen($username) < 3 || strlen($username) > 32)
            return false;
        return !preg_match('/[^a-zA-Z0-9_.]/', $username);
    }
}
