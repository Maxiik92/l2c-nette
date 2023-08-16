<?php

declare(strict_types=1);

namespace App\Components\User\Sign\In;

//TRAITA sluzi na implementaciu kodu ktory je pre presenter specificky
trait PresenterTrait{
    protected string $storeRequestId = '';

    private ControlFactory $userSignInControlFactory;

    public function injectUserSignInControlFactory(ControlFactory $controlFactory){
        $this->userSignInControlFactory = $controlFactory;
    }

    public function createComponentSignInForm(): Control
	{
		return $this->userSignInControlFactory->create([$this,'onSignInFormSuccess']);
	}

	public function onSignInFormSuccess()
	{
		$this->flashMessage('Login Successfull', 'success');
		$this->restoreRequest($this->storeRequestId);
		$this->redirect('Homepage:');
	}

}