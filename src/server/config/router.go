package config

import (
	"encoding/json"
	"tht-payment/controller"
	"tht-payment/middleware"

	"github.com/gofiber/fiber/v2"
	"github.com/gofiber/fiber/v2/middleware/recover"
)

func NewRouter(PaymentController controller.PaymentController) *fiber.App {
	server := fiber.New(fiber.Config{
		Prefork:       true,
		CaseSensitive: true,
		StrictRouting: true,
		ServerHeader:  "Fiber",
		AppName:       "THT Payment Server",
		ErrorHandler:  nil,
		JSONEncoder:   json.Marshal,
		JSONDecoder:   json.Unmarshal,
	})

	server.Use(middleware.Auth)
	server.Use(recover.New())

	server.Post("/deposit", PaymentController.Deposit)

	return server
}
