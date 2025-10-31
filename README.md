# SafraPLUS
![License](https://img.shields.io/badge/license-MIT-green)
![Framework](https://img.shields.io/badge/Framework-Laravel-red)
![Database](https://img.shields.io/badge/Database-MySQL-blue)

SafraPLUS é um **Sistema Gerenciador Financeiro voltado para Produtores Rurais**, desenvolvido para centralizar a gestão financeira, produtiva e operacional das atividades agrícolas em uma plataforma web responsiva.

Este projeto foi desenvolvido como avaliação para a disciplina de "Eletiva II Programação Web" do 5º Termo de Análise e Desenvolvimento de Sistemas da Fatec Presidente Prudente.

## 🎯 Objetivo Principal

O objetivo do sistema é permitir que o produtor rural abandone planilhas complexas e sistemas genéricos, oferecendo uma ferramenta onde todos os lançamentos financeiros são obrigatoriamente vinculados a uma safra específica. Isso permite o **cálculo automático e preciso da lucratividade de cada ciclo produtivo**.

## ✨ Funcionalidades Implementadas

* **Gestão de Safras:** CRUD completo de ciclos produtivos (cultura, área plantada, datas, etc.).
* **Controle Financeiro:** Lançamento detalhado de custos (insumos, custos operacionais) e receitas (vendas).
* **Gestão de Recursos:** Cadastro e controle de Insumos, Maquinários e Mão de Obra.
* **Gestão de Estoque:** Movimentação de entrada (compra) e saída (uso em safra) de insumos, com atualização automática do inventário.
* **Relatórios e Dashboard:** Painel inicial com KPIs (Receitas, Despesas, Saldo) e relatórios de lucratividade por safra.
* **Sistema Multi-Usuário com Permissões:**
    * **Admin:** Gerencia todo o sistema, podendo criar, editar e visualizar todos os usuários.
    * **Produtor:** Acessa o sistema e visualiza/gerencia **apenas** os dados (safras, finanças, insumos) que ele mesmo cadastrou.
