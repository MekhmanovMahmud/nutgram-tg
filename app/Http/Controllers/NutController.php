<?php
namespace App\Http\Controllers;
use Psr\Log\InvalidArgumentException;
use Psy\Readline\Hoa\Exception;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class NutController extends Controller
{
    public function show(){
        $bot = new Nutgram($_ENV['TELEGRAM_TOKEN']);
        $bot->onCommand('start', function (Nutgram $bot) {
            $kb = ['reply_markup' =>
                ['keyboard' => [
                    [
                        ['text' => '🍴 Меню'],
                    ],
                    [
                        ['text' => '🛍 Мои заказы'],
                    ],
                    [
                        ['text' => '✍️ Оставить отзыв'],
                        ['text' => '⚙️ Настройки'],
                    ],
                ], 'resize_keyboard' => true]
            ];
            $bot->sendMessage("Выберите одно из следующих", $kb);
        });

        $bot->onText('🍴 Меню', function (Nutgram $bot) {

            $kb2 = ['reply_markup' =>
                ['keyboard' => [
                    [
                        ['text' => '📍 отправить геолокацию', 'request_location'=> true],
                        ['text' => '☎ отправить контакты','request_contact'=> true],
                    ],
                    [
                        ['text' => '⬅ назад'],

                    ],
                ], 'resize_keyboard' => true]
            ];

            $bot->sendMessage("Выберите", $kb2);
            $bot->answerCallbackQuery();
        });

        $bot->onText('⬅ назад', function (Nutgram $bot) {
            $kb = ['reply_markup' =>
                ['keyboard' => [
                    [
                        ['text' => '🍴 Меню'],
                    ],
                    [
                        ['text' => '🛍 Мои заказы'],
                    ],
                    [
                        ['text' => '✍️ Оставить отзыв'],
                        ['text' => '⚙️ Настройки'],
                    ],
                ], 'resize_keyboard' => true]
            ];
            $bot->sendMessage("Выберите одно из следующих ", $kb);

        });

        $bot->run();

    }


}
