<?php

namespace App\Domain\Coin\Filament\Resources\CoinResource\Widgets;

use App\Domain\Coin\Contracts\CoinChartDataContract;
use Carbon\Carbon;
use Filament\Support\RawJs;
use LaraZeus\InlineChart\InlineChartWidget;

class CoinPriceWidget extends InlineChartWidget
{
    /**
     * The column span for the widget.
     *
     * @var int|string|array
     */
    protected int | string | array $columnSpan = 'full';

    /**
     * The heading for the widget.
     *
     * @var string|null
     */
    protected static ?string $heading = 'Chart';

    /**
     * The maximum hight for the chart inside the widget.
     *
     * @var string|null
     */
    protected static ?string $maxHeight = '100px';

    /**
     * Get the chart configuration.
     *
     * @return array
     */
    protected function getData(): array
    {
        $coinChartDataService = app(CoinChartDataContract::class);

        $chartData = $coinChartDataService->getCoinPriceChartDataBetweenDates(
            id: $this->record->remote_id,
            startDate: Carbon::now()->subDays(1),
            endDate: Carbon::now(),
            intervalInMinutes: 60,
            currency: config('currency.default_currency')
        );

        return [
            'datasets' => [
                [
                    'label' => 'Price (USD)',
                    'data' => $chartData['data'],
                    // if the last price is greater than the first price, set the color to green, otherwise red
                    'borderColor' => $chartData['data']->last() > $chartData['data']->first() ? 'rgb(0, 255, 0)' : 'rgb(255, 0, 0)',
                    'pointBackgroundColor' => 'rgb(255, 255, 255)',
                ],
            ],
            'labels' => $chartData['labels'],
        ];
    }

    /**
     * Get the chart type.
     *
     * @return string
     */
    protected function getType(): string
    {
        return 'line';
    }

    /**
     * Get the options for the chart.
     *
     * @return RawJs
     */
    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
        {
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    enabled: true
                }
            },
            scales: {
                y: {
                    ticks: {
                        display: false,
                    },
                    grid: {
                        display: false,
                    },
                },
                x: {
                    ticks: {
                        display: false,
                    },
                    grid: {
                        display: false,
                    },
                },
            },
        }
        JS);
    }
}
