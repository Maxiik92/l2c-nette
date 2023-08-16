<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\PostModel;
use App\Model\RoleModel;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{

	public function __construct(
		private PostModel $postModel,
		private RoleModel $roleModel
	) {
	}


	public function renderDefault(): void
	{
		$this->template->posts = $this->postModel
			->getPublicArticles()
			->limit(5);
	}
}