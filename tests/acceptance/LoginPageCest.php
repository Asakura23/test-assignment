<?php

class LoginPageCest
{
    const EMAIL_FIELD = "div.authorization input[id='loginform-email']";
    const PASSWORD_FIELD = "div.authorization input[id='loginform-password']";
    const  BUTTON_LOGIN = "div.authorization  div.form-group.form-group__large > button";
    const BUTTON_FORGOT_PASSWORD = "div.authorization a[href='/site/restore-password']";

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement(self::EMAIL_FIELD);
    }

    /**
     * login fields test
     * @param AcceptanceTester $I
     * @param \Codeception\Example $example
     * @return null|AssertFailedError
     * @example ["test@mail.test","12345678","Некорректный email / пароль"]
     * @example ["","","Необходимо заполнить «Электронная почта»|Необходимо заполнить «Пароль»"]
     */
    public function testLoginFields(AcceptanceTester $I,\Codeception\Example $example)
    {
        $texts = explode("|",$example[2]);

        $I->wantToTest('1/2.Вход с невалидными логином/паролем и вход без ввода данных');
        $I->fillField(self::EMAIL_FIELD,$example[0]);
        $I->fillField(self::PASSWORD_FIELD,$example[1]);
        $I->click(self::BUTTON_LOGIN);
        $I->waitForText($texts[0]);

        foreach ($texts as $text => $value){
            $I->see($value);
        }
    }
    /**
     * password field mask test
     * @param AcceptanceTester $I
     * @return null|AssertFailedError
     */
    public function testPasswordFieldIsMasked(AcceptanceTester $I)
    {
        $I->wantToTest('3.Проверка маскировки пароля');
        $I->assertEquals('password',$I->grabAttributeFrom(self::PASSWORD_FIELD,'type'));
    }
    /**
     * forgot password button test
     * @param AcceptanceTester $I
     * @return null|AssertFailedError
     */
    public function testButtonForgotPassword(AcceptanceTester $I)
    {
        $I->wantToTest('4.Переход по ссылке «Забыли пароль»');
        $I->click(self::BUTTON_FORGOT_PASSWORD);
        $I->waitForText('Восстановление пароля');
        $I->seeInCurrentUrl('/site/restore-password');
    }
}
