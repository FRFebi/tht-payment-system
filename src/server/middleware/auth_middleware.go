package middleware

import (
	"tht-payment/model/web"

	"github.com/gofiber/fiber/v2"
)

func Auth(ctx *fiber.Ctx) error {
	if ctx.Get("Authorization") == "Bearer Rmlrb1JlZGhhRmViaWFuc3lhaA==" {
		return ctx.Next()
	}

	code := fiber.ErrUnauthorized.Code
	response := web.PaymentResponse{
		OrderId: "",
		Amount:  0,
		Status:  2,
	}

	err := ctx.Status(code).JSON(response)
	if err != nil {
		return ctx.Status(fiber.StatusInternalServerError).SendString("Internal Server Error")
	}
	return nil
}
