<?php

namespace App\Http\Controllers\admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\WithdrawFunds;

class AdminDashboardController extends Controller
{
    //
    public function UserArticle()
    {
        $articles = Article::with('User')->latest()->paginate(5);
        return view('admin.usersarticle', ['article' => $articles]);
    }

    public function changeArticleStatus($id)
    {

        $user = Article::select('status')->where('id', '=', $id)->first();
        if ($user->status == 'approved') {
            $status = 'pending';
        } else {
            $status = 'approved';
        }
        $value = array('status' => $status);
        Article::where('id', $id)->update($value);

        return redirect()->back()->with('success', 'Status Updated Successfully!');
    }



    public function deleteArticle($id)
    {

        Article::find($id)->delete();

        return redirect()->back()->with('success', 'Article deleted successfully!');
    }

    public function withDraw()

    {
        $withdraw = WithdrawFunds::with('user')->latest()->get();
        return view('admin.withdraw', ['withdraw' => $withdraw]);
    }

    public function withdawChangeStatus($id)
    {

        $user = WithdrawFunds::select('status')->where('id', '=', $id)->first();
        if ($user->status == 'approved') {
            $status = 'pending';
        } else {
            $status = 'approved';
        }
        $value = array('status' => $status);
        WithdrawFunds::where('id', $id)->update($value);

        return redirect()->back()->with('success', 'Status Updated Successfully!');
    }


    public function deleteWithdraw($id)
    {

        WithdrawFunds::find($id)->delete();

        return redirect()->back()->with('success', 'Article deleted successfully!');
    }


    public function Referrals()
    {
        $referral = Referral::with('userRelation', 'referralRelation')->latest()->get();

        return view('admin.referrals', ['referral'=> $referral]);





    }
}
