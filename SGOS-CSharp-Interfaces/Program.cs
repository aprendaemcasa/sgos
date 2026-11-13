using System.Drawing;
using System.Windows.Forms;

namespace SGOS;

internal static class Program
{
    [STAThread]
    static void Main()
    {
        ApplicationConfiguration.Initialize();
        Application.Run(new LoginForm());
    }
}

internal static class Theme
{
    public static readonly Color Navy = Color.FromArgb(17, 31, 54);
    public static readonly Color Blue = Color.FromArgb(45, 105, 190);
    public static readonly Color Background = Color.FromArgb(244, 247, 251);
    public static readonly Color Muted = Color.FromArgb(111, 125, 145);

    public static Button Button(string text, bool primary = false)
    {
        var b = new Button { Text = text, Height = 40, AutoSize = true, Padding = new Padding(14, 0, 14, 0),
            FlatStyle = FlatStyle.Flat, BackColor = primary ? Blue : Color.White,
            ForeColor = primary ? Color.White : Navy, Font = new Font("Segoe UI", 9.5f, FontStyle.Bold),
            Cursor = Cursors.Hand, Margin = new Padding(5) };
        b.FlatAppearance.BorderSize = primary ? 0 : 1;
        b.FlatAppearance.BorderColor = Color.FromArgb(220, 228, 238);
        return b;
    }
}

public class LoginForm : Form
{
    public LoginForm()
    {
        Text = "SGOS | Acesso ao sistema"; StartPosition = FormStartPosition.CenterScreen;
        Size = new Size(920, 580); MinimumSize = new Size(760, 500); BackColor = Theme.Background;
        var brand = new Panel { Dock = DockStyle.Left, Width = 370, BackColor = Theme.Navy };
        brand.Controls.Add(new Label { Text = "SGOS", ForeColor = Color.White, Font = new Font("Segoe UI", 36, FontStyle.Bold), AutoSize = true, Location = new Point(55, 165) });
        brand.Controls.Add(new Label { Text = "Sistema de Gerenciamento\nde Ordens de Serviço", ForeColor = Color.Gainsboro, Font = new Font("Segoe UI", 15), AutoSize = true, Location = new Point(60, 235) });
        Controls.Add(brand);
        var area = new Panel { Dock = DockStyle.Fill, BackColor = Color.White, Padding = new Padding(55) };
        Controls.Add(area); area.BringToFront();
        area.Controls.Add(new Label { Text = "Bem-vindo!", Font = new Font("Segoe UI", 24, FontStyle.Bold), ForeColor = Theme.Navy, AutoSize = true, Location = new Point(55, 70) });
        area.Controls.Add(new Label { Text = "Acesse a demonstração das interfaces do SGOS.", ForeColor = Theme.Muted, AutoSize = true, Location = new Point(58, 120) });
        area.Controls.Add(new Label { Text = "E-mail", Location = new Point(58, 185), AutoSize = true });
        var email = new TextBox { PlaceholderText = "Digite seu e-mail", Location = new Point(55, 210), Width = 290 };
        area.Controls.Add(email);
        area.Controls.Add(new Label { Text = "Senha", Location = new Point(58, 265), AutoSize = true });
        var password = new TextBox { PlaceholderText = "Digite sua senha", Location = new Point(55, 290), Width = 290, UseSystemPasswordChar = true };
        area.Controls.Add(password);
        var enter = Theme.Button("Entrar no sistema", true); enter.Location = new Point(55, 355); enter.Width = 290; enter.Height = 44;
        enter.Click += (_, _) => { Hide(); using var dashboard = new DashboardForm(); dashboard.ShowDialog(); Close(); };
        area.Controls.Add(enter);
        area.Controls.Add(new Label { Text = "Modo demonstrativo • não utiliza banco de dados", ForeColor = Theme.Muted, AutoSize = true, Location = new Point(55, 425) });
    }
}

public class DashboardForm : Form
{
    private readonly Panel page = new();
    public DashboardForm()
    {
        Text = "SGOS | Painel principal"; WindowState = FormWindowState.Maximized;
        MinimumSize = new Size(1050, 680); BackColor = Theme.Background;
        var side = new Panel { Dock = DockStyle.Left, Width = 235, BackColor = Theme.Navy };
        side.Controls.Add(new Label { Text = "SGOS", ForeColor = Color.White, Font = new Font("Segoe UI", 25, FontStyle.Bold), AutoSize = true, Location = new Point(24, 22) });
        side.Controls.Add(new Label { Text = "GESTÃO DE SERVIÇOS", ForeColor = Color.LightSteelBlue, Font = new Font("Segoe UI", 8, FontStyle.Bold), AutoSize = true, Location = new Point(28, 63) });
        AddNav(side, "▦   Visão geral", 120, ShowDashboard, true);
        AddNav(side, "♙   Clientes", 171, () => OpenModule("Clientes", new[] { "Código", "Nome", "Telefone", "E-mail" }, new[] { new[] { "001", "Maria Oliveira", "(99) 99999-1111", "maria@email.com" }, new[] { "002", "João Santos", "(99) 99999-2222", "joao@email.com" } }));
        AddNav(side, "▤   Serviços", 222, () => OpenModule("Serviços", new[] { "Código", "Descrição", "Valor", "Status" }, new[] { new[] { "001", "Manutenção preventiva", "R$ 150,00", "Ativo" }, new[] { "002", "Instalação", "R$ 250,00", "Ativo" } }));
        AddNav(side, "▣   Ordens de serviço", 273, () => OpenModule("Ordens de serviço", new[] { "Nº OS", "Cliente", "Serviço", "Status" }, new[] { new[] { "1024", "Maria Oliveira", "Manutenção", "Em andamento" }, new[] { "1023", "João Santos", "Instalação", "Concluída" } }));
        AddNav(side, "⚙   Usuários", 324, () => OpenModule("Usuários", new[] { "Código", "Nome", "E-mail", "Perfil" }, new[] { new[] { "001", "Administrador", "admin@sgos.com", "Administrador" } }));
        AddNav(side, "↪   Sair", 405, Close);
        Controls.Add(side);
        var top = new Panel { Dock = DockStyle.Top, Height = 68, BackColor = Color.White };
        top.Controls.Add(new Label { Text = "Sistema de Gerenciamento de Ordens de Serviço", AutoSize = true, Location = new Point(26, 23), Font = new Font("Segoe UI", 11, FontStyle.Bold), ForeColor = Theme.Navy });
        Controls.Add(top);
        page.Dock = DockStyle.Fill; page.BackColor = Theme.Background; page.Padding = new Padding(30);
        Controls.Add(page); page.BringToFront(); top.BringToFront();
        ShowDashboard();
    }

    private void AddNav(Panel p, string text, int y, Action action, bool active = false)
    {
        var b = new Button { Text = text, TextAlign = ContentAlignment.MiddleLeft, Location = new Point(12, y), Size = new Size(210, 43),
            FlatStyle = FlatStyle.Flat, BackColor = active ? Color.FromArgb(43, 78, 124) : Theme.Navy,
            ForeColor = Color.White, Font = new Font("Segoe UI", 9.5f), Cursor = Cursors.Hand };
        b.FlatAppearance.BorderSize = 0; b.Click += (_, _) => action(); p.Controls.Add(b);
    }

    private void ShowDashboard()
    {
        page.Controls.Clear();
        page.Controls.Add(new Label { Text = "Visão geral", AutoSize = true, Location = new Point(30, 18), Font = new Font("Segoe UI", 24, FontStyle.Bold), ForeColor = Theme.Navy });
        page.Controls.Add(new Label { Text = "Acompanhe os indicadores e a movimentação do sistema.", AutoSize = true, Location = new Point(34, 62), ForeColor = Theme.Muted });
        Metric("CLIENTES CADASTRADOS", "128", "Total registrado", 30, 115, Color.FromArgb(45, 105, 190));
        Metric("ORDENS EM ABERTO", "24", "Aguardando conclusão", 310, 115, Color.FromArgb(226, 151, 48));
        Metric("SERVIÇOS CONCLUÍDOS", "86", "Ordens finalizadas", 590, 115, Color.FromArgb(37, 157, 112));
        var activity = new Panel { Location = new Point(30, 275), Size = new Size(570, 270), BackColor = Color.White };
        activity.Controls.Add(new Label { Text = "Atividades recentes", AutoSize = true, Location = new Point(22, 18), Font = new Font("Segoe UI", 13, FontStyle.Bold), ForeColor = Theme.Navy });
        Activity(activity, "Ordem de serviço #1024", "Manutenção preventiva • Em andamento", 70);
        Activity(activity, "Novo cliente cadastrado", "Maria Oliveira foi adicionada ao sistema", 130);
        Activity(activity, "Ordem de serviço #1023", "Instalação • Concluída", 190);
        page.Controls.Add(activity);
        var quick = new Panel { Location = new Point(625, 275), Size = new Size(300, 270), BackColor = Color.White };
        quick.Controls.Add(new Label { Text = "Acesso rápido", AutoSize = true, Location = new Point(20, 18), Font = new Font("Segoe UI", 13, FontStyle.Bold), ForeColor = Theme.Navy });
        Quick(quick, "Cadastrar cliente", 65, () => OpenModule("Clientes", new[] { "Código", "Nome", "Telefone", "E-mail" }, Array.Empty<string[]>()));
        Quick(quick, "Novo serviço", 115, () => OpenModule("Serviços", new[] { "Código", "Descrição", "Valor", "Status" }, Array.Empty<string[]>()));
        Quick(quick, "Ver ordens de serviço", 165, () => OpenModule("Ordens de serviço", new[] { "Nº OS", "Cliente", "Serviço", "Status" }, Array.Empty<string[]>()));
        page.Controls.Add(quick);
    }

    private void Metric(string title, string value, string detail, int x, int y, Color accent)
    {
        var card = new Panel { Location = new Point(x, y), Size = new Size(260, 135), BackColor = Color.White };
        card.Controls.Add(new Panel { Location = new Point(0, 0), Size = new Size(5, 135), BackColor = accent });
        card.Controls.Add(new Label { Text = title, AutoSize = true, Location = new Point(18, 17), ForeColor = Theme.Muted, Font = new Font("Segoe UI", 8, FontStyle.Bold) });
        card.Controls.Add(new Label { Text = value, AutoSize = true, Location = new Point(18, 43), ForeColor = Theme.Navy, Font = new Font("Segoe UI", 27, FontStyle.Bold) });
        card.Controls.Add(new Label { Text = detail, AutoSize = true, Location = new Point(20, 103), ForeColor = Theme.Muted });
        page.Controls.Add(card);
    }

    private void Activity(Panel p, string title, string detail, int y)
    {
        p.Controls.Add(new Panel { Location = new Point(20, y), Size = new Size(4, 38), BackColor = Theme.Blue });
        p.Controls.Add(new Label { Text = title, AutoSize = true, Location = new Point(34, y), Font = new Font("Segoe UI", 9.5f, FontStyle.Bold), ForeColor = Theme.Navy });
        p.Controls.Add(new Label { Text = detail, AutoSize = true, Location = new Point(34, y + 20), Font = new Font("Segoe UI", 8.5f), ForeColor = Theme.Muted });
    }

    private void Quick(Panel p, string text, int y, Action action)
    {
        var b = Theme.Button("＋  " + text); b.Location = new Point(18, y); b.Width = 260; b.TextAlign = ContentAlignment.MiddleLeft;
        b.Click += (_, _) => action(); p.Controls.Add(b);
    }

    private void OpenModule(string title, string[] columns, string[][] rows)
    {
        using var f = new ModuleForm(title, columns, rows); f.ShowDialog(this);
    }
}

public class ModuleForm : Form
{
    public ModuleForm(string title, string[] columns, string[][] rows)
    {
        Text = "SGOS | " + title; Size = new Size(950, 600); StartPosition = FormStartPosition.CenterParent; BackColor = Theme.Background;
        var header = new Panel { Dock = DockStyle.Top, Height = 72, BackColor = Color.White };
        header.Controls.Add(new Label { Text = title, AutoSize = true, Location = new Point(24, 17), Font = new Font("Segoe UI", 21, FontStyle.Bold), ForeColor = Theme.Navy });
        Controls.Add(header);
        var grid = new DataGridView { Dock = DockStyle.Fill, ReadOnly = true, AllowUserToAddRows = false, RowHeadersVisible = false,
            BackgroundColor = Color.White, AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill, SelectionMode = DataGridViewSelectionMode.FullRowSelect };
        grid.EnableHeadersVisualStyles = false; grid.ColumnHeadersDefaultCellStyle.BackColor = Theme.Navy; grid.ColumnHeadersDefaultCellStyle.ForeColor = Color.White;
        foreach (var c in columns) grid.Columns.Add(c, c);
        foreach (var r in rows) grid.Rows.Add(r);
        Controls.Add(grid); grid.BringToFront(); header.BringToFront();
    }
}
