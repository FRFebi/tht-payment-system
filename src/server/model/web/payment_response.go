package web

type PaymentResponse struct {
	OrderId string `json:"order_id"`
	Amount  int    `json:"amount"`
	Status  int32  `json:"status"`
}
