package service

import (
	"context"
	"math/rand"
	"tht-payment/model/web"
	"time"

	"github.com/go-playground/validator/v10"
)

type PaymentServiceImpl struct {
	Validate *validator.Validate
}

func NewPaymentService(validate *validator.Validate) *PaymentServiceImpl {
	return &PaymentServiceImpl{Validate: validate}
}

func (service *PaymentServiceImpl) Add(ctx context.Context, request web.PaymentRequest) web.PaymentResponse {
	err := service.Validate.Struct(request)
	if err != nil {
		panic(err)
	}

	rand.Seed(time.Now().UnixNano())
	min := 1
	max := 2
	random := rand.Intn(max-min+1) + min
	return web.PaymentResponse{OrderId: request.OrderId, Amount: request.Amount, Status: int32(random)}
}

func (service *PaymentServiceImpl) Substract(ctx context.Context, request web.PaymentRequest) web.PaymentResponse {
	err := service.Validate.Struct(request)
	if err != nil {
		panic(err)
	}

	rand.Seed(time.Now().UnixNano())
	min := 1
	max := 2

	random := rand.Intn(max-min+1) + min
	return web.PaymentResponse{OrderId: request.OrderId, Amount: request.Amount, Status: int32(random)}

}
