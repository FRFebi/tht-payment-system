package controller

import (
	"tht-payment/model/web"
	"tht-payment/service"

	"github.com/gofiber/fiber/v2"
)

type PaymentControllerImpl struct {
	PaymentService service.PaymentService
}

func NewPaymentController(PaymentService service.PaymentService) PaymentController {
	return &PaymentControllerImpl{
		PaymentService: PaymentService,
	}
}

func (controller *PaymentControllerImpl) Deposit(ctx *fiber.Ctx) error {
	ctx.Accepts("application/json")
	paymentRequest := &web.PaymentRequest{}
	errParsing := ctx.BodyParser(paymentRequest)
	if errParsing != nil {
		panic(errParsing)
	}

	paymentResponse := controller.PaymentService.Add(ctx.UserContext(), *paymentRequest)
	// apiResponse := &web.APIResponse{
	// 	Code:   200,
	// 	Status: "OK",
	// 	Data:   paymentResponse,
	// }
	ctx.Set("Content-Type", "application/json")
	return ctx.JSON(paymentResponse)
}

func (controller *PaymentControllerImpl) Withdraw(ctx *fiber.Ctx) error {
	ctx.Accepts("application/json")
	paymentRequest := &web.PaymentRequest{}
	errParsing := ctx.BodyParser(paymentRequest)
	if errParsing != nil {
		panic(errParsing)
	}

	paymentResponse := controller.PaymentService.Substract(ctx.UserContext(), *paymentRequest)
	// apiResponse := &web.APIResponse{
	// 	Code:   200,
	// 	Status: "OK",
	// 	Data:   paymentResponse,
	// }
	ctx.Set("Content-Type", "application/json")
	return ctx.JSON(paymentResponse)
}
