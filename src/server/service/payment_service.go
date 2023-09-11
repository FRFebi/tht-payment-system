package service

import (
	"context"
	"tht-payment/model/web"
)

type PaymentService interface {
	Add(ctx context.Context, request web.PaymentRequest) web.PaymentResponse
	Substract(ctx context.Context, request web.PaymentRequest) web.PaymentResponse
}
