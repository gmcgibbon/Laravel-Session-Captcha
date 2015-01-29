<?php

/**
 * Comment Controller
 * 
 * Comment creator and viewer
 */
class CommentController extends Controller
{
	/**
	 * Display comment creation form
	 * 
	 * @return Comment creation view
	 */
	public function create()
	{
		return View::make('comment.create')
			->with(['comment' => new Comment()]);
	}

	/**
	 * Show specific comment (unused)
	 * 
	 * @param id Post database ID
	 * 
	 * @return Comment show view
	 */
	public function show($id)
	{
		$comment = Comment::find($id);

		return View::make('comment.show')
			->with(['comment' => $comment]);
	}

	/**
	 * Display all comments
	 * 
	 * @return All comments view
	 */
	public function all()
	{
		$comments = Comment::orderBy('created_at', 'desc')
			->orderBy('id', 'desc')
			->get();

		return View::make('comment.all')
			->with(['comments' => $comments]);
	}

	/**
	 * Adds Comment to database
	 * 
	 * @return Comment creation form on error 
	 * 		   or all comments view on success
	 */
	public function add()
	{
		if (CaptchaHelper::getInstance()->validate()) // check captcha
		{
			$comment = new Comment(Input::all());

			if ($comment->save()) // try save and validate via ardent
			{
				Session::flash('success', 'Your comment has been posted!');
				
				return Redirect::route('comment.all');
			}
			else
			{
				Session::flash('fail', 'There was a problem posting your comment!');

				return Redirect::back()
					->withInput(Input::except('captcha'))
					->withErrors($comment->errors()->all());
			}
		}
		else
		{
			$status  = CaptchaHelper::getInstance()->status();
			$message = "Captcha was incorrect, you have {$status['count_left']} " . 
					   "attempts left in the next {$status['time_left']} seconds";

			return Redirect::back()
					->withInput(Input::except('captcha'))
					->withErrors($message);
		}
	}
}
