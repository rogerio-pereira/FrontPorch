<?php

use App\Notifications\SlackNotification;
use Illuminate\Notifications\Slack\SlackMessage;

it('sends through the slack channel', function () {
    $notification = new SlackNotification('New website lead');

    expect($notification->via(new stdClass))->toBe(['slack']);
});

it('builds a slack message with the provided text', function () {
    $text = "New website lead\nName: Alex Rivera";
    $notification = new SlackNotification($text);

    $message = $notification->toSlack(new stdClass);

    expect($message)->toBeInstanceOf(SlackMessage::class);

    $reflection = new ReflectionClass($message);
    $textProperty = $reflection->getProperty('text');
    $textProperty->setAccessible(true);

    expect($textProperty->getValue($message))->toBe($text);
});
