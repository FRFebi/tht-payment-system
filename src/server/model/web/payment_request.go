package web

type PaymentRequest struct {
	OrderId   string `json:"order_id"`
	Amount    int    `json:"amount"`
	Timestamp string `json:"timestamp"`
}
