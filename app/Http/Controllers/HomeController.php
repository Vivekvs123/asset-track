<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Models\AssetType;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function assettype()
    {
        return view('admin.assettype');
    }
    public function postassettype(Request $req)
    {
        $validate = $req->validate([
            'type' => 'required|unique:asset_types',
            'description' => 'required|max:500'
        ]);
        if ($validate) {
            $c = AssetType::create([
                'type' => $req->type,
                'description' => $req->description

            ]);
            return redirect('/displaytype');
        } else {
            return back()->with('error', "something went wrong");
        }
    }
    public function displaytype()
    {
        $type = AssetType::all();
        return view('admin.displaytype', compact('type'));
    }
    public function edittype($id)
    {
        $edittype = AssetType::where('id', $id)->first();
        return view('admin.edittype', compact('edittype'));
    }
    public function postedittype(Request $req, $id)
    {
        $edit = AssetType::where('id', $id)->first();
        $validate = $req->validate([
            'type' => 'required',
            'description' => 'required|max:500'
        ]);
        if ($validate) {
            AssetType::where('id', $id)->update([
                'type' => $req->type,
                'description' => $req->description
            ]);
            return redirect('/displaytype');
        }
    }
    public function deletetype(Request $req)
    {
        $typedata = AssetType::where('id', $req->cid)->first();
        $assettype = AssetType::find($req->cid);
        if ($assettype->delete()) {
            return redirect('displaytype');
        } else {
            return "Asset type does not Deleted";
        }
    }
    public function assets()
    {
        $p = $type = Asset::paginate(2);
        $type = AssetType::all();
        return view('admin.assets', compact('type'));
    }
    public function displayasset()
    {
        $asset = Asset::all();
        $type = AssetType::all();
        return view('admin.displayasset', compact('type', 'asset'));
    }

    public function editassets($id)
    {
        $editassets = Asset::where('id', $id)->first();
        $type = AssetType::all();
        return view('admin.editassets', compact('editassets', 'type'));
    }
    public function postasset(Request $req)
    {
        $validate = $req->validate([
            'name' => 'required|min:2',
            'file' => 'required|mimes:jpg,png,jpeg,PNG,JPG,JPEG'
        ]);
        if ($validate) {
            $file = $req->file('file');
            $dest = public_path('/uploads');
            $filename = "Image-" . rand() . "-" . time() . "." . $file->extension();
            if ($file->move($dest, $filename)) {
                $c = Asset::create([
                    'uid' => $req->type,
                    'name' => $req->name,
                    'code' => $req->code,
                    'image' => $filename,
                    'isactive' => $req->isactive
                ]);
                return redirect('/displayasset');
            } else {
                $path = public_path() . "uploads/" . $filename;
                unlink($path);
                return back()->with('errMsg', 'uploading error');
            }
        } else {
            return back()->with('error', "something went wrong");
        }
    }
    public function posteditasset(Request $req, $id)
    {
        $assettype = AssetType::where('id', $id)->first();
        $edit = Asset::where('id', $id)->first();
        $validate = $req->validate([
            'name' => 'required|min:2',
            'file' => 'required|mimes:jpg,png,jpeg,PNG,JPG,JPEG'
        ]);
        if ($validate) {
            $file = $req->file('file');
            $dest = public_path('/uploads');
            $filename = "Image-" . rand() . "-" . time() . "." . $file->extension();
            if ($file->move($dest, $filename)) {
                Asset::where('id', $id)->update([
                    'uid' => $req->type,
                    'name' => $req->name,
                    'image' => $filename,
                    'isactive' => $req->isactive
                ]);
                return redirect('/displayasset');
            } else {
                $path = public_path() . "uploads/" . $filename;
                unlink($path);
                return back()->with('errMsg', 'uploading error');
            }
        } else {
            return back()->with('error', "something went wrong");
        }
    }
    public function deleteasset(Request $req)
    {
        $typedata = Asset::where('id', $req->cid)->first();
        $asset = Asset::find($req->cid);
        if ($asset->delete()) {
            return redirect('displayasset');
        } else {
            return "Asset type does not Deleted";
        }
    }


    public function dashboard()
    {
        // 

        $result = DB::select(DB::raw("select type,count(type) as total from asset_types group by type"));
        $chartdata = "";
        foreach ($result as $list) {
            $chartdata .= "['" . $list->type . "',   " . $list->total . "],";
        }
        $arr['chartData'] = rtrim($chartdata, ",");
        return view('admin.dashboard', $arr);
    }
    public function barchart(){
        $result=DB::select(DB::raw("SELECT name,count(name) as total FROM assets  GROUP BY name"));
        $chartdata="";
        foreach($result as $list){
            $chartdata.="['".$list->name."',   ".$list->total."],";

        }
       
        $arr['chartData']=rtrim($chartdata,",");
        return view('admin.barchart',$arr);
    }
}
