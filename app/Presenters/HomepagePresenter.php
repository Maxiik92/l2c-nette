<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\PostModel;
use App\Model\RoleModel;
use App\Presenters\BasePresenter;
use Nette;


final class HomepagePresenter extends BasePresenter
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