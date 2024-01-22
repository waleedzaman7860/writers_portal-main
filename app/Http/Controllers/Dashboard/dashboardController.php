<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\WithdrawFunds;
use App\Models\ArticleHistory;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    //
    public function Dashboard()
    {
        $id = Auth::user()->id;
        $article = Article::where('user_id', $id)->where('status', 'approved')->get();


        // return $articleStatus;
        $countWriterArticle = count($article);
        $a = []; // Initialize the $a array

        foreach ($article as $articles) {
            $a[] = $articles->article_earning;
        }
        $countArticleEarnings = array_sum($a);

        $user = User::find($id);
        $membership_deposite = $user->membership_deposite;
        $joining_bonus = $user->joining_bonus;
        $referralEarning = $user->referral_earning;

        $combinedArray = array($membership_deposite, $joining_bonus, $countArticleEarnings, $referralEarning);
        $totalearning = array_sum($combinedArray);

        $getLatestArticle = Article::where(['user_id' => $id])->whereDate('created_at', '>', Carbon::now()->subDay())->latest()->first();
        $remainingHoursForSubmission = null;

        // dd($getLatestArticle);
        if ($getLatestArticle) {
            $nextSubmissionTime = $getLatestArticle->created_at->addHour(24);
            $remainingHoursForSubmission = Carbon::now()->diffInHours($nextSubmissionTime);
        }

        //AFTER_30_ARTICLE_SUBMISSION_ARTICLE_WILL_SUBMIT
        $getLatestWithdraw = ArticleHistory::where('user_id', Auth::user()->id)->latest()->first();
        $getLatestWithdrawDate = null;
        if ($getLatestWithdraw) {
            $getLatestWithdrawDate = $getLatestWithdraw->withdraw_date;
        }

        $data = null;
        $countArticle = '0';

        if (Article::count() > 0) {
            $getLatestWithdrawDate = Carbon::parse($getLatestWithdrawDate);
            $data = Article::where('created_at', '>', $getLatestWithdrawDate)
                ->orderBy('created_at')
                // ->take(30)
                ->get();

            if ($data) {
                $countArticle = count($data);
            }
        }

        return view(
            'pages.dashboard',
            [
                'user' => $user,
                'totalearning' => $totalearning,
                'countWriterArticle' => $countWriterArticle,
                'countArticleEarnings' => $countArticleEarnings,
                'referralEarning' => $referralEarning,
                'remainingHoursForSubmission' => $remainingHoursForSubmission,
                'countArticle' => $countArticle,
            ]
        );
    }

    public function SaveArticle(Request $request)
    {
        $request->validate([
        'article_document' => 'nullable|file|mimes:ppt,pptx,doc,docx,pdf,xls,xlsx|max:204800',
        // 'article_text'  =>'max:255'
        ]);
        $userId = Auth::user()->id;

        $getUser = \App\Models\User::where('id', $userId)->first();
        $getUserInitialDeposite = $getUser->membership_deposite;
        $percentage = 0.005;
        $calculatedAmount = $getUserInitialDeposite * $percentage;


        $articleText = $request->article_text ?? '';
        $depositeSlipPath = null;

        if (isset($request->article_document) && $request->article_document instanceof UploadedFile) {
            $depositeSlipPath = $request->article_document->store('article-documnt', 'public');
            $success = Article::create([
                'user_id' => $userId,
                'article_file' => $depositeSlipPath ?? '',
                'article_type' => 'file',
                'status' => 'approved',
                'article_earning' => $calculatedAmount,
            ]);
        } else {
            $success = Article::create([
                'user_id' => $userId,
                'article' => $articleText,
                'article_type' => 'text',
                'status' => 'approved',
                'article_earning' => $calculatedAmount,
            ]);
        }


        if ($success) {

            return response()->json([
                'status' => 'fail',
                'msg' => 'Not Submitted',

            ]);
            // return redirect()->back()->with('success', 'Your article is submitted');
        }
    }


    public function WithdrawRequest(Request $request)
    {

        $request->validate([
            'user_bep_wallet_address' => 'required',
        ]);

        if ($request->total_earning >= 10) {
            if (ArticleHistory::count() < 1) {
                $getLatestWithdrawArticle = Article::where('user_id', Auth::user()->id)->latest()->first();
                $getLatestWithdrawArticleDate = $getLatestWithdrawArticle->created_at;
                ArticleHistory::create([
                    'user_id' => Auth::user()->id,
                    'withdraw_date' => $getLatestWithdrawArticleDate,
                ]);
            }
            $getLatestWithdraw = ArticleHistory::where('user_id', Auth::user()->id)->latest()->first();
            $getLatestWithdrawDate = $getLatestWithdraw->withdraw_date;

            $getLatestWithdrawDate = Carbon::parse($getLatestWithdrawDate);

            $data = Article::where('created_at', '>', $getLatestWithdrawDate)
                ->orderBy('created_at')
                // ->take(30)
                ->get();
            $countArticle = count($data);
            if ($countArticle > 1) {
                $getLastArticle = $data->last();
                $getDateFromLastArticle = $getLastArticle->created_at;
                ArticleHistory::create([
                    'user_id' => Auth::user()->id,
                    'withdraw_date' => $getDateFromLastArticle,
                ]);

                WithdrawFunds::create([
                    'user_id' => Auth::user()->id,
                    'bep_wallet_address' => $request->user_bep_wallet_address,
                    'withdraw_amount' => $request->total_earning,
                    'status' => 'pending',
                ]);
                User::where('id', Auth::user()->id)->first()->update([
                    'membership_deposite' => 0,
                    'joining_bonus' => 0,
                    'referral_earning' => 0,


                ]);


                Article::where('user_id', Auth::user()->id)->update([
                    'article_earning' => 0,
                    'withdraw_date' => $getDateFromLastArticle,



                ]);
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Withdraw request submitted',

                ]);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Articles are less than 30',

                ]);
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'msg' => 'Not Submitted',

            ]);
        }
    }
}
