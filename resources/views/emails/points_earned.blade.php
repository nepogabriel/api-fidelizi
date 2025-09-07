<x-mail::message>
# 🎉 Parabéns, {{ $customer->name }}!  

Você acaba de ganhar **{{ $points }} pontos** no nosso Programa de Fidelidade! 🏆  

Obrigado por realizar sua compra. Seus pontos foram adicionados com sucesso ao seu saldo.  

---

## **Detalhes do Pedido**
- **Valor da Compra:** R$ {{ $orderAmount }}
- **Pontos Ganhos:** {{ $points }}
- **Novo Saldo Total:** {{ $customer->points }} pontos  

Se você não realizou essa compra ou acredita que houve um erro, entre em contato com nossa equipe de suporte imediatamente.  

Obrigado,<br>
**Equipe Fidelizi**
</x-mail::message>

