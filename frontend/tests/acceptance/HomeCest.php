<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('My Application');

        $I->seeLink('Cards');
        $I->wait(2);
        $I->click('Cards');
        $I->wait(2); // wait for page to be opened
        $I->see('Deadline');
        $I->seeLink('Task22');
        $I->wait(2);
        $I->click('Task22');
        $I->wait(2);
        $I->fillField('Tasks[name]', 'Task23');
        $I->wait(2);
        $I->click('Save');
        $I->wait(2);
        $I->see('Task23');
        $I->wait(4);

    }
}
