<?php

namespace User\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
//    public function __construct(private readonly string $text)
//    {
//
//    }

    public function index(): string
    {
        return $this->render("user/index.html.twig", ["test" => "test please work"]);

    }
}