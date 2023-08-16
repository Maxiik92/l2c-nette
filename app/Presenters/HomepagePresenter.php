<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\PostModel;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
	private PostModel $postModel;


	public function __construct(PostModel $postModel)
	{
		$this->postModel = $postModel;
	}


	public function renderDefault(): void
	{
		$this->template->posts = $this->postModel
			->getPublicArticles()
			->limit(5);
	}
}
