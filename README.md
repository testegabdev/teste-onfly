# Instruções e considerações

- Para ter acesso ao banco com massa de teste pré pronta, cole essas configurações de banco público que disponibilizei no seu env: 
```bash
DATABASE_URL=mysql://root:vYErFJoV6Ds6jw5cNajQ@containers-us-west-22.railway.app:7708/railway
DB_CONNECTION=mysql
DB_HOST=containers-us-west-22.railway.app
DB_PORT=7708
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=vYErFJoV6Ds6jw5cNajQ
```
- Para o envio de emails, coloque um email que possa utilizar o cliente SMTP com mais facilidade. O gmail não permite contas menos seguras para fazerem isso. No meu caso coloquei uma conta teste do outlook.

```bash

MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=testgabdev@outlook.com
MAIL_PASSWORD=******************
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=testgabdev@outlook.com
MAIL_FROM_NAME="${APP_NAME}"
```

- Fiz o simples, arquiteturas complexas com mais camadas e abstrações eram desnecessárias para esse pequeno projeto. Optei apenas por utilizar o mais básico: Model, Controller e Middleware. Esse foi um dos motivos por não usar Policies, meu middlware tinha uma regra tão simples para uma aplicação tão pequena, que preferi apenas criar uma classe `OwnerCheckMiddleware` e bala!

- O insomnia com as rotas está disponibilizado na raíz do projeto
- Para que o serviço de email seja colocado numa fila, não se esqueça de abrir um segundo terminal e rodar: `php artisan queue:work`
