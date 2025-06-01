<?php

namespace App\Domain\Portfolio\Filament\Resources\PortfolioResource\Widgets;

use App\Domain\Portfolio\Contracts\PortfolioChartDataContract;
use Carbon\Carbon;
use Filament\Support\RawJs;
use LaraZeus\InlineChart\InlineChartWidget;

class PortfolioTotalValueWidget extends InlineChartWidget
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
     * Determine if the widget can be viewed on Dashboard.
     *
     * @return bool
     */
    public static function canView(): bool
    {
        return false;
    }

    /**
     * Get the chart configuration.
     *
     * @return array
     */
    protected function getData(): array
    {
        $portfolioChartDataService = app(PortfolioChartDataContract::class);

        // set up to show the portfolio value chart for the last 24 hours in 1 hour intervals
        $chartData = $portfolioChartDataService->getPortfolioValueChartDataBetweenDates(
            id: $this->record->id,
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
