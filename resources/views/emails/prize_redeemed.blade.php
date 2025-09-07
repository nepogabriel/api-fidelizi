<x-mail::message>
# 🎁 Parabéns, {{ $customer->name }}!  

Você acaba de resgatar o prêmio **{{ $prize->name }}** no nosso Programa de Fidelidade! 🏆  

---

## **Detalhes do Resgate**
- **Prêmio Resgatado:** {{ $prize->name }}
- **Pontos Utilizados:** {{ $prize->points }}
- **Novo Saldo de Pontos:** {{ $customer->points }} pontos  

Se você não realizou este resgate ou acredita que houve um erro, entre em contato com nossa equipe de suporte imediatamente.  

Obrigado,<br>
**Equipe Programa de Fidelidade**
</x-mail::message>
