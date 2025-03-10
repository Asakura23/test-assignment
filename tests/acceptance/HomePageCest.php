<?php

class HomePageCest
{
    const HOME_BUTTON = 'div.header__sticky-wrapper > div > div > a > svg';
    const COMMON_PART_NAVIGATION = "#__layout > div > header > div.header__sticky-wrapper > div > div > div > nav > ul > li > a[href='REPLACE']";
    const COMMON_PART_COMPANY  = "#__layout > div > main > div > div > section.section.section-clients > ul > li > a[aria-label='REPLACE']";
    const BUTTON_SEND = "#form > form > div.form__button-container > button[class='form__send-form-button button']";
    const COMMON_PART_FORM = "#form > form > div.form__inputs-container input[placeholder='REPLACE']";

    protected $name = 'testName';
    protected $tel = '8999999999';
    protected $email = 'test@mail.ru';
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement(self::HOME_BUTTON);
    }
    /**
     * navigation clickability test#1
     * @param AcceptanceTester $I
     * @param \Codeception\Example $example
     * @return null|AssertFailedError
     * @example ["/about"]
     * @example ["/academy"]
     * @example ["/events"]
     * @example ["/blog/"]
     * @example ["/vacancies"]
     * @example ["/contacts"]
     */
    public function testNavigation(AcceptanceTester $I,\Codeception\Example $example)
    {
        $I->click(str_replace('REPLACE',$example[0],self::COMMON_PART_NAVIGATION));
        $I->waitForElement(self::HOME_BUTTON);
        $I->seeInCurrentUrl($example[0]);
    }
    /**
     * navigation clickability test #2
     * @param AcceptanceTester $I
     * @param \Codeception\Example $example
     * @return null|AssertFailedError
     * @example ["Рольф","www.rolf.ru"]
     * @example ["Медси","medsi.ru"]
     * @example ["omniboard360","navigatror.sk.ru"]
     * @example ["Ингосстрах","ingos.ru"]
     * @example ["М.ВидеоЭльдорадо","mvideoeldorado.ru"]
     * @example ["Леруа Мерлен","leroymerlin.ru"]
     * @example ["Технониколь","tn.ru"]
     */
    public function testNavigationCompany(AcceptanceTester $I,\Codeception\Example $example)
    {
        $I->scrollTo(self::BUTTON_SEND);
        $I->waitForElementVisible(self::BUTTON_SEND);
        $I->click(str_replace('REPLACE',$example[0],self::COMMON_PART_COMPANY));
        $I->wait(3);
        $I->seeInCurrentUrl("https://".$example[1]);
        $I->closeTab();
        $I->wait(1);
        $I->waitForElement(self::HOME_BUTTON);
    }
    /**
     * validation form test#2
     * @param AcceptanceTester $I
     * @return null|AssertFailedError
     */
    public function testValidationForm(AcceptanceTester $I)
    {
        $I->scrollTo(self::BUTTON_SEND);
        $I->waitForElementVisible(self::BUTTON_SEND);
        $I->click(self::BUTTON_SEND);
        $I->waitForElement('p.form__error');
    }
    /**
     * validation form test#2
     * @param AcceptanceTester $I
     * @return null|AssertFailedError
     */
    public function testValidationFormSend(AcceptanceTester $I)
    {
        $inputs = ['Имя*'=>$this->name,'Телефон*'=>$this->tel,'Почта*'=>$this->email];

        $I->scrollTo(self::BUTTON_SEND);
        $I->waitForElementVisible(self::BUTTON_SEND);

        foreach ($inputs as $input => $value){
            $I->fillField(str_replace('REPLACE',$input,self::COMMON_PART_FORM),$value);
        }
        $I->click(self::BUTTON_SEND);
        $I->waitForText('Ваше обращение получено');
    }
}
