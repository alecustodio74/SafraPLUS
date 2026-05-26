<?php

namespace App\Http\Controllers;

use App\Models\LancamentoFinanceiro;
use App\Models\Safra;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LancamentoFinanceiroController extends Controller
{
    public function index(Request $request)
    {
        $usuarioLogado = Auth::user();
        $safraIds = $usuarioLogado->safras->pluck('id');

        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');
        $mesFiltro = $request->input('mes_filtro');
        $filtro = $request->input('filtro', 'saldo_atual');
        $safraFiltro = $request->input('safra_id_filtro');

        if ($safraFiltro) {
            $safraIds = collect([$safraFiltro]);
        }

        $movimentacoes = collect();

        // 1. Lancamentos Financeiros
        if (in_array($filtro, ['saldo_atual', 'receitas'])) {
            $receitas = LancamentoFinanceiro::with('safra', 'categoria')
                ->whereIn('safra_id', $safraIds)
                ->where('tipo_receita_custo', 'receita')
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'id' => $item->id,
                        'data_lancamento' => $item->data_lancamento,
                        'descricao' => $item->descricao,
                        'safra' => (object) ['cultura' => $item->safra->cultura ?? 'N/A', 'produtor' => $item->safra->produtor ?? null],
                        'categoria' => (object) ['nome' => $item->categoria->nome ?? 'N/A'],
                        'tipo_receita_custo' => 'receita',
                        'quantidade' => $item->quantidade,
                        'valor_total' => $item->valor_total,
                        'is_lancamento' => true,
                    ];
                });
            $movimentacoes = $movimentacoes->concat($receitas);
        }

        if (in_array($filtro, ['saldo_atual', 'despesas'])) {
            $despesasLanc = LancamentoFinanceiro::with('safra', 'categoria')
                ->whereIn('safra_id', $safraIds)
                ->whereIn('tipo_receita_custo', ['custo', 'despesa'])
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'id' => $item->id,
                        'data_lancamento' => $item->data_lancamento,
                        'descricao' => $item->descricao,
                        'safra' => (object) ['cultura' => $item->safra->cultura ?? 'N/A', 'produtor' => $item->safra->produtor ?? null],
                        'categoria' => (object) ['nome' => $item->categoria->nome ?? 'N/A'],
                        'tipo_receita_custo' => 'custo',
                        'quantidade' => $item->quantidade,
                        'valor_total' => $item->valor_total,
                        'is_lancamento' => true,
                    ];
                });

            $custosOp = \App\Models\CustoOperacional::with(['maoDeObra', 'maquinario', 'safra'])
                ->whereIn('safra_id', $safraIds)
                ->get()
                ->map(function ($item) {
                    $descParts = [];
                    if ($item->maoDeObra) $descParts[] = $item->maoDeObra->nome_ou_tipo;
                    if ($item->maquinario) $descParts[] = $item->maquinario->nome_modelo;
                    $vinculo = count($descParts) > 0 ? ' (' . implode(' / ', $descParts) . ')' : '';
                    $desc = 'Custo Op: ' . $item->descricao . $vinculo;
                    return (object) [
                        'id' => $item->id,
                        'data_lancamento' => $item->data,
                        'descricao' => $desc,
                        'safra' => (object) ['cultura' => $item->safra->cultura ?? 'N/A', 'produtor' => $item->safra->produtor ?? null],
                        'categoria' => (object) ['nome' => 'Custo Operacional'],
                        'tipo_receita_custo' => 'custo',
                        'quantidade' => null,
                        'valor_total' => $item->valor,
                        'is_lancamento' => false,
                    ];
                });

            if ($safraFiltro) {
                $insumos = \App\Models\MovimentacaoEstoque::with(['insumo', 'safra'])
                    ->whereIn('safra_id', $safraIds)
                    ->where('tipo_movimentacao', 'saida')
                    ->get()
                    ->map(function ($item) {
                        return (object) [
                            'id' => $item->id,
                            'data_lancamento' => $item->data_movimentacao,
                            'descricao' => 'Uso de Insumo: ' . ($item->insumo->nome ?? 'N/A'),
                            'safra' => (object) ['cultura' => $item->safra->cultura ?? 'N/A', 'produtor' => $item->safra->produtor ?? null],
                            'categoria' => (object) ['nome' => 'Insumo'],
                            'tipo_receita_custo' => 'custo',
                            'quantidade' => $item->quantidade,
                            'valor_total' => $item->quantidade * $item->valor_unitario,
                            'is_lancamento' => false,
                        ];
                    });
            } else {
                $insumos = \App\Models\MovimentacaoEstoque::with('insumo')
                    ->whereIn('insumo_id', $usuarioLogado->insumos->pluck('id'))
                    ->where('tipo_movimentacao', 'entrada')
                    ->get()
                    ->map(function ($item) {
                        return (object) [
                            'id' => $item->id,
                            'data_lancamento' => $item->data_movimentacao,
                            'descricao' => 'Compra Insumo: ' . ($item->insumo->nome ?? 'N/A'),
                            'safra' => (object) ['cultura' => 'Estoque Geral', 'produtor' => null],
                            'categoria' => (object) ['nome' => 'Insumo'],
                            'tipo_receita_custo' => 'custo',
                            'quantidade' => $item->quantidade,
                            'valor_total' => $item->quantidade * $item->valor_unitario,
                            'is_lancamento' => false,
                        ];
                    });
            }

            $movimentacoes = $movimentacoes->concat($despesasLanc)->concat($custosOp)->concat($insumos);
        }

        if ($dataInicio) {
            $movimentacoes = $movimentacoes->where('data_lancamento', '>=', $dataInicio);
        }
        if ($dataFim) {
            $movimentacoes = $movimentacoes->where('data_lancamento', '<=', $dataFim);
        }
        if ($mesFiltro) {
            $movimentacoes = $movimentacoes->filter(function ($item) use ($mesFiltro) {
                return substr($item->data_lancamento, 0, 7) == $mesFiltro;
            });
        }

        $movimentacoes = $movimentacoes->sortByDesc('data_lancamento')->values();

        $totalReceitas = $movimentacoes->where('tipo_receita_custo', 'receita')->sum('valor_total');
        $totalDespesas = $movimentacoes->where('tipo_receita_custo', 'custo')->sum('valor_total');
        $saldo = $totalReceitas - $totalDespesas;

        // Paginação Manual
        $perPage = 10;
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $lancamentos = new \Illuminate\Pagination\LengthAwarePaginator(
            $movimentacoes->forPage($page, $perPage),
            $movimentacoes->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $safras = $usuarioLogado->safras;

        return view('lancamentos_financeiros.index', compact(
            'lancamentos', 'totalReceitas', 'totalDespesas', 'saldo',
            'dataInicio', 'dataFim', 'mesFiltro', 'filtro', 'safras', 'safraFiltro'
        ));
    }

    public function create()
    {
        $usuarioLogado = Auth::user();
        $safras = $usuarioLogado->safras()->whereNull('data_fim')->get();
        $categorias = $usuarioLogado->categorias;

        return view('lancamentos_financeiros.create', compact('safras', 'categorias'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();

        $dados = $request->validate([
            'safra_id' => [
                'required',
                'exists:safras,id',
                function ($attribute, $value, $fail) {
                    $safra = \App\Models\Safra::find($value);
                    if ($safra && !empty($safra->data_fim)) {
                        $fail('Não é possível atribuir registros a uma safra concluída.');
                    }
                },
            ],
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_receita_custo' => 'required|in:receita,custo',
            'descricao' => 'required|string|max:255',
            'valor_total' => 'required|numeric|min:0',
            'data_lancamento' => 'required|date',
            'quantidade' => 'nullable|numeric|min:0',
            'preco_unitario' => 'nullable|numeric|min:0',
            'comprador' => 'nullable|string|max:255',
            'desconto_taxa' => 'nullable|numeric|min:0',
        ]);

        $usuarioLogado->safras()->findOrFail($request->safra_id);

        if ($dados['tipo_receita_custo'] === 'receita') {
            $dados['valor_liquido'] = $dados['valor_total'] - ($dados['desconto_taxa'] ?? 0);
        } else {
            $dados['valor_liquido'] = null;
            $dados['comprador'] = null;
            $dados['desconto_taxa'] = null;
        }

        LancamentoFinanceiro::create($dados);

        return redirect()->route('lancamentos-financeiros.index')->with('success', 'Lançamento criado com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $safraIds = $usuarioLogado->safras->pluck('id');
        $lancamento = LancamentoFinanceiro::whereIn('safra_id', $safraIds)->findOrFail($id);
        $safras = $usuarioLogado->safras()->where(function($q) use ($lancamento) {
            $q->whereNull('data_fim')->orWhere('id', $lancamento->safra_id);
        })->get();
        $categorias = $usuarioLogado->categorias;

        return view('lancamentos_financeiros.edit', compact('lancamento', 'safras', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $safraIds = $usuarioLogado->safras->pluck('id');
        $lancamento = LancamentoFinanceiro::whereIn('safra_id', $safraIds)->findOrFail($id);

        $dados = $request->validate([
            'safra_id' => [
                'required',
                'exists:safras,id',
                function ($attribute, $value, $fail) {
                    $safra = \App\Models\Safra::find($value);
                    if ($safra && !empty($safra->data_fim)) {
                        $fail('Não é possível atribuir registros a uma safra concluída.');
                    }
                },
            ],
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_receita_custo' => 'required|in:receita,custo',
            'descricao' => 'required|string|max:255',
            'valor_total' => 'required|numeric|min:0',
            'data_lancamento' => 'required|date',
            'quantidade' => 'nullable|numeric|min:0',
            'preco_unitario' => 'nullable|numeric|min:0',
            'comprador' => 'nullable|string|max:255',
            'desconto_taxa' => 'nullable|numeric|min:0',
        ]);

        if ($dados['tipo_receita_custo'] === 'receita') {
            $dados['valor_liquido'] = $dados['valor_total'] - ($dados['desconto_taxa'] ?? 0);
        } else {
            $dados['valor_liquido'] = null;
            $dados['comprador'] = null;
            $dados['desconto_taxa'] = null;
        }

        $lancamento->update($dados);

        return redirect()->route('lancamentos-financeiros.index')->with('success', 'Lançamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $safraIds = $usuarioLogado->safras->pluck('id');
        $lancamento = LancamentoFinanceiro::whereIn('safra_id', $safraIds)->findOrFail($id);

        $lancamento->delete();

        return redirect()->route('lancamentos-financeiros.index')->with('success', 'Lançamento excluído com sucesso!');
    }
}
