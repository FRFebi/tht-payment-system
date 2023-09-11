package main

import (
	"log"
	"tht-payment/config"
	"tht-payment/controller"
	"tht-payment/service"

	"github.com/go-playground/validator/v10"
)

func main() {
	validate := validator.New()

	PaymentService := service.NewPaymentService(validate)
	PaymentController := controller.NewPaymentController(PaymentService)

	router := config.NewRouter(PaymentController)

	log.Fatal(router.Listen(":8888"))
}
