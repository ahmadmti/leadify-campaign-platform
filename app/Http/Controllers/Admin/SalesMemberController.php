<?php

namespace App\Http\Controllers\Admin;


use App\Classes\Common;

use App\Http\Requests\Admin\SalesMember\DeleteRequest;
use App\Http\Requests\Admin\SalesMember\IndexRequest;
use App\Http\Requests\Admin\SalesMember\StoreRequest;
use App\Http\Requests\Admin\SalesMember\UpdateRequest;

use App\Classes\Reply;
use App\Models\Appointment;
use App\Models\Callback;
use App\Models\Campaign;
use App\Models\Form;
use App\Models\Lead;
use App\Models\Role;
use App\Models\User;
use App\Models\SalesMember;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SalesMemberController extends AdminBaseController
{
     /**
	 * UserController constructor.
	 */

    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = trans('menu.salesMembers');
        $this->pageIcon = 'fa fa-user-tie';
        $this->userManagementMenuActive = 'active';
        $this->salesMemberActive = 'active';
    }

    /**
     * @param IndexRequest $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(IndexRequest $request)
    {
        
        return view('admin.users.sales.index', $this->data);
    }

     /**
	 * @return mixed
	 */
    public function getLists()
   
    {

        $users = User::where('sales_member' ,'1')->select('id', 'image', 'first_name', 'last_name', 'email', 'status', 'created_at');

        return datatables()->eloquent($users)
            ->editColumn('first_name', function ($row) {
                return Common::getUserWidget($row);
            })
            ->editColumn(
                'status',
                function ($row) {
                    $color = ['enabled' => 'success', 'disabled' => 'danger', 'waiting' => 'warning'];
                    return "<div class='badge badge-".$color[$row->status]."'>".
                        trans('app.'.$row->status). '</span>';
                }
            )
            ->editColumn(
                'email',
                function ($row) {
                    $data = $row->email. ' ';

                    if($row->email_verified == 'yes') {
                        $data .= '<i class="fa fa-check-circle" style="color: green;"></i>';
                    }

                    return $data;
                }
            )
            ->editColumn(
                'created_at',
                function ($row) {
                    return $row->created_at->format('d F, Y');
                }
            )
            ->addColumn('action', function ($row) {

                    if($row->id == 1 && $this->user->id != $row->id)
                    {
                        $text = trans('messages.notAllowed');
                    } else {
                        $text = '<div class="buttons">';

                        if($this->user->ability('admin', 'staff_edit')) {
                            $text .= '<a href="javascript:void(0);" onclick="editModal(' . $row->id . ')" class="btn btn-info btn-icon icon-left"
                      data-toggle="tooltip" data-original-title="' . trans('app.edit') . '"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        }

                        if($this->user->ability('admin', 'staff_delete')) {
                            if ($row->id != 1 && $this->user->id != $row->id) {
                                $text .= '<button onclick="deleteModal(' . $row->id . ')" class="btn btn-danger btn-icon icon-left"
                          data-toggle="tooltip" data-original-title="' . trans('app.delete') . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                            }
                        }

                        $text .= '</div>';
                    }



                return $text;
            })
            ->rawColumns(['first_name', 'action', 'status', 'email'])
            ->make(true);
    }


    public function create()
    {

        $this->icon = 'plus';

        $this->userDetails = new User();
        $this->roles = Role::all();
        return view('admin.users.sales.add-edit', $this->data);
    }

    public function store(StoreRequest $request)
    {
        try {
           
        //   return $request->all();
        \DB::beginTransaction();

        $user = new User();
     
        $this->storeAndUpdate($user, $request);
        // Saving Twilio Client Name
        $name = trim(strtolower($user->first_name));
        if($user->last_name != '')
        {
            $name .= ' '. trim(strtolower($user->last_name));
        }
        $name = str_replace(' ', '_', $name);
        $checkIfNameAlreadyExists = \App\Models\User::where('twilio_client_name', $name)->count();
        if($checkIfNameAlreadyExists > 0)
        {
            $name = $name.'_'.$user->id;
        }
        $user->twilio_client_name = $name;
        $user->sales_member = 1;
        $user->save();
        \DB::commit();
        return Reply::success('messages.createSuccess');
        } catch (\Exception $th ) {
            return $th;
           }
        

    }

    public function edit($id)
    {

        $this->icon = 'edit';
        $this->userDetails = User::find($id);
        $this->roles = Role::all();

        // Call the same create view for edit
        return view('admin.users.sales.add-edit', $this->data);
    }

    public function update(UpdateRequest $request,$id)
    {
// return $id;
        try {
            \DB::beginTransaction();

             $user         = User::find($id);
        
            if($request->hasFile('image'))
            {
                $largeLogo  = $request->file('image');
       
                $fileName   = 'user_'.strtolower(Str::random(20)).'.'.$largeLogo->getClientOriginalExtension();
                $largeLogo->move($this->userImagePath, $fileName);
       
                //Deleting previous image
                $this->deleteUserImage($user->image);
       
                $user->image        = $fileName;
            }
       
            if($request->password != '')
            {
                $user->password = Hash::make($request->password);
            }
       
            $user->first_name   = $request->first_name;
            $user->last_name   = $request->last_name;
            $user->email = $request->email;
            $user->contact_number = $request->contact_number;
            $user->skype_id = $request->skype_id;
            $user->address = $request->address;
            $user->country = $request->country;
            $user->zip_code = $request->zip_code;
            $user->status = $request->status;
          
            $role = Role::where('name',strtolower('Sales'))->first();
            $roleID = $role->id; 

            if ($roleID != $request->role_id) {
                 $user->sales_member = 0;
            }
            $user->update();
            
            $SalesMember         = SalesMember::where('user_id',$id)->first();
            // return $SalesMember;
          
         $SalesMember->first_name   = $request->first_name;
         $SalesMember->last_name   = $request->last_name;
         $SalesMember->email = $request->email;
         $SalesMember->contact_number = $request->contact_number;
         $SalesMember->skype_id = $request->skype_id;
    
         $SalesMember->save();

         if($request->has('role_id') && $request->role_id != '' && $this->user->ability('admin', 'assign_role') && $this->user->id != $user->id && $user->id != 1)
        {
            $roleID = $request->role_id;

            $user->updateRole($roleID);
        }
        else {
            $role = Role::where('name',strtolower('Sales'))->first();
            $roleID = $role->id; 
            $user->updateRole($roleID);
        }
            \DB::commit();
            return Reply::success('messages.updateSuccess');
    
        } catch (\Exception $th ) {
            return $th;
           }
      
    }

    public function destroy(DeleteRequest $request, $id)
    {

        try {
            $SalesMember  = SalesMember::where('user_id',$id);
            $SalesMember->delete();
             // Can not delete admin or himself
     if($this->user->id == $id || $id == 1)
     {
         return Reply::error('messages.notAllowed');
     }
        // After deleting this user assign all leads, appintments and pending callbacks to user who delete it
        Lead::where('first_actioned_by', $id)
            ->update(['first_actioned_by' => $this->user->id]);
        Lead::where('last_actioned_by', $id)
            ->update(['last_actioned_by' => $this->user->id]);
        Campaign::where('created_by', $id)
                ->update(['created_by' => $this->user->id]);
        Appointment::where('created_by', $id)
            ->update(['created_by' => $this->user->id]);
        Callback::where('attempted_by', $id)
            ->update(['attempted_by' => $this->user->id]);
        Form::where('created_by', $id)
            ->update(['created_by' => $this->user->id]);


        $user  = User::find($id);

        //Deleting image
        $this->deleteUserImage($user->image);

        $user->delete();
       
        return Reply::success('messages.deleteSuccess');
        } catch (\Exception $th ) {
            return $th;
           }
    
    }

    private function  storeAndUpdate($user, $request)
    {
       
        // return $request->all();
     // If User Image uploaded
     if($request->hasFile('image'))
     {
         $largeLogo  = $request->file('image');

         $fileName   = 'user_'.strtolower(Str::random(20)).'.'.$largeLogo->getClientOriginalExtension();
         $largeLogo->move($this->userImagePath, $fileName);

         //Deleting previous image
         $this->deleteUserImage($user->image);

         $user->image        = $fileName;
     }

     if($request->password != '')
     {
         $user->password = Hash::make($request->password);
     }

     $user->first_name   = $request->first_name;
     $user->last_name   = $request->last_name;
     $user->email = $request->email;
     $user->contact_number = $request->contact_number;
     $user->skype_id = $request->skype_id;
     $user->address = $request->address;
     $user->country = $request->country;
     $user->zip_code = $request->zip_code;
     $user->status = $request->status;
    //  $user->sales_member = ;
     $user->save();
     $SalesMember = new SalesMember();
   

        //  $SalesMember->image        = $fileName;
    
     $SalesMember->user_id   = $user->id;
     $SalesMember->first_name   = $request->first_name;
     $SalesMember->last_name   = $request->last_name;
     $SalesMember->email = $request->email;
     $SalesMember->contact_number = $request->contact_number;
     $SalesMember->skype_id = $request->skype_id;

     $SalesMember->save();

     
     if($request->has('role_id') && $request->role_id != '' && $this->user->ability('admin', 'assign_role') && $this->user->id != $user->id && $user->id != 1)
        {
            $roleID = $request->role_id;

            $user->updateRole($roleID);
        }
        else {
            $role = Role::where('name',strtolower('Sales'))->first();
            $roleID = $role->id; 
            $user->updateRole($roleID);
        }
    }

    protected function deleteUserImage($imagePath)
    {
        if($imagePath != null) {
            if (File::exists($this->userImagePath . '/' . $imagePath))
            {
                Common::deleteCommonFiles($this->userImagePath . '/' . $imagePath);
            }
        }
    }

}
