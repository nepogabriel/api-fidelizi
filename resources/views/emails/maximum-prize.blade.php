<x-mail::message>
# 🎉 Olá, {{ $customer->name }}!  

Temos uma ótima notícia para você! 🎁  
Agora você possui **{{ $customer->points }} pontos** disponíveis e já pode resgatar o **prêmio máximo** do nosso Programa de Fidelidade! 🏆  

---

## **Detalhes do Prêmio**
- **Prêmio:** {{ $prize->name }}
- **Pontos Necessários:** {{ $prize->points }}
- **Seus Pontos Atuais:** {{ $customer->points }}

Corra! Os prêmios são limitados e podem acabar rapidamente.  

Obrigado por fazer parte do nosso programa!  
**Equipe Programa de Fidelidade**
</x-mail::message>
