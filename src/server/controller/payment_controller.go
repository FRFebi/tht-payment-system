package controller

import "github.com/gofiber/fiber/v2"

type PaymentController interface {
	Deposit(c *fiber.Ctx) error
	Withdraw(c *fiber.Ctx) error
}
